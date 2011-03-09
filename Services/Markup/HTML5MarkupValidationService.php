<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Services\Markup;

use Liip\ValidationServiceBundle\Services\AbstractValidationService;
use Liip\ValidationServiceBundle\Results\ValidationMessage;
use Liip\ValidationServiceBundle\Results\ValidationResult;
use Liip\ValidationServiceBundle\Helper\DocumentWrapper;
use Liip\ValidationServiceBundle\Filters\IFilter;

/**
 * HTML5 markup validation service based on http://validator.nu
 *
 * In case of intensive usage of the validation service,  you are strongly encouraged to install
 * your own instance of the service (see http://about.validator.nu/#src)
 *
 * @see IMarkupValidator
 * @author Daniel Barsotti
 * @copyright (c) 2010-2011 Liip
 */
class HTML5MarkupValidationService extends AbstractValidationService
{
    /**
     * Default URI of the validation service
     * @var string
     */
    protected $service_uri = 'http://validator.nu/';

    /**
     * {@inheritdoc}
     */
    public function __construct(IFilter $filter = null)
    {
        parent::__construct($filter);
    }

    function getDefaultFragmentWrapper()
    {
        return DocumentWrapper::HTML5_WRAPPER;
    }

    /**
     * Modify the URI of the validation service
     * @param string $uri The uri of your local validation service
     */
    public function setValidatorUri($uri)
    {
        $this->service_uri = $uri;
    }

    /**
     * Return the availability of the validation service
     * @return boolean
     */
    public function isReady()
    {
        $content = DocumentWrapper::wrap('Hello Validator', $this->getDefaultFragmentWrapper());
        $res = $this->queryValidator($content, 'POST');
        return ($res === "{\"messages\":[]}\n");
    }

    /**
     * Validate a web page given its URI
     * @param string $uri
     * @return ValidationResult
     */
    public function validateUri($uri)
    {
        $res = $this->queryValidator($uri, 'GET');
        return $this->buildResults($res);
    }

    /**
     * Validate a complete HTML document
     * @param string $html
     * @return ValidationResult
     */
    public function validateString($html)
    {
        $res = $this->queryValidator($html, 'POST');
        return $this->buildResults($res);
    }
    
    /**
     * Transform the response of the validator service in ValidationResult
     * @param string $res
     * @return ValidationResult
     */
    protected function buildResults($res)
    {
        $result = new ValidationResult();
        if ($res) {
            $decoded_res = json_decode($res);
            $messages = array();

            $count = 0;
            foreach($decoded_res->messages as $row) {
                if ($row->type === 'info') {
                    $msg = new ValidationMessage(0, 0, $row->message, '', $row->type);
                } else {
                    $msg = new ValidationMessage(
                        isset($row->lastLine) ? $row->lastLine : 0,
                        isset($row->lastColumn) ? $row->lastColumn : 0,
                        isset($row->message) ? $row->message : '',
                        isset($row->extract) ? $row->extract : '',
                        isset($row->type) ? $row->type : ''
                    );
                }
                if (! $this->result_filter || $this->result_filter->filter($msg)) {
                    $result->addMessage($msg);
                    $count++;
                }
            }

            $result->setIsValid($count === 0);
            return $result;
        }

        return false;
    }

    /**
     * Query the validation service
     * @param string $data The URI to validate when $method = 'GET' or the html to validate when $method = 'POST'
     * @param string $method Either 'GET or 'POST'
     * @return string
     */
    protected function queryValidator($data, $method = 'GET')
    {
        $is_post = false;
        if ($method === 'GET') {
            $service_uri = $this->service_uri . '?out=json&parser=html';
            $service_uri .= '&doc=' . urlencode($data);
        } elseif($method == 'POST') {
            $is_post = true;
            $service_uri = $this->service_uri;
        } else {
            throw new \InvalidArgumentException("Invalid query method $method");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service_uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($is_post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'out' => 'json',
                'parser' => 'html5',
                'content' => $data,
            ));
        }

        $res = curl_exec($ch);

        curl_close($ch);

        return $res;
    }

}
