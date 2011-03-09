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

require_once 'Services/W3C/HTMLValidator.php';

/**
 * Markup validator using the http://validator.w3.org/ web service
 *
 * In case of intensive usage of the validation service,  you are strongly encouraged to install
 * your own instance of the service (see http://validator.w3.org/source/)
 *
 * This class requires the pear Services_W3C_HTMLValidator
 *
 *      pear install Services_W3C_HTMLValidator
 *
 * @see IMarkupValidator
 * @author Daniel Barsotti
 * @copyright (c) 2010-2011 Liip
 */
class W3CMarkupValidationService extends AbstractValidationService
{
    /**
     * Default URI of the validation service
     * @var string
     */
    protected $validator_service = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(IFilter $filter = null)
    {
        parent::__construct($filter);
        
        $this->validator_service = new \Services_W3C_HTMLValidator();
    }

    function getDefaultFragmentWrapper()
    {
        return DocumentWrapper::XHTML_STRICT_WRAPPER;
    }

    /**
     * Modify the URI of the validation service
     * @param string $uri The uri of your local validation service
     */
    public function setValidatorUri($uri)
    {
        $this->validator_service->validator_uri = $uri;
    }

    /**
     * Return the availability of the validation service
     * @return boolean
     */
    public function isReady()
    {
        try {
            $this->validator_service->validateFragment('Test');
            return true;
        } catch (\Services_W3C_HTMLValidator_Exception $e) {
            return false;
        }
    }

    /**
     * Validate a web page given its URI
     * @param string $uri
     * @return ValidationResult
     */
    public function validateUri($uri)
    {
        $res = $this->validator_service->validate($uri);
        return $this->buildResults($res);
    }

    /**
     * Validate a complete HTML document
     * @param string $html
     * @return ValidationResult
     */
    public function validateString($html)
    {
        $res = false;
        if ($html) {
            $res = $this->validator_service->validateFragment($html);
        }
        return $this->buildResults($res);
    }
    
    /**
     * Transform the response of the validator service to a valid IMarkupValidator return array
     * @param Services_W3C_HTMLValidator_Response $res
     * @return ValidationResult
     */
    protected function buildResults($res)
    {
        if (!$res instanceof  \Services_W3C_HTMLValidator_Response) {
            return false;
        }

        $messages = array();
        foreach ($res->errors as $row) {
            $msg = new ValidationMessage($row->line, $row->col, $row->message, $row->source);

            if ($row instanceof  \Services_W3C_HTMLValidator_Warning) {
                $msg->setLevel('warning');
            } elseif ($row instanceof \Services_W3C_HTMLValidator_Error) {
                $msg->setLevel('error');
            } else {
                $msg>setLevel('info');
            }

            $messages[] = $msg;
        }

        $result = new ValidationResult(false, $messages);
        $this->filterResults($result);
        $result->setIsValid($res->isValid() || count($result->getMessages()) === 0);
        return $result;
    }

}
