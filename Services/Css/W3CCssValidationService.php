<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Services\Css;

use Liip\ValidationServiceBundle\Services\AbstractValidationService;
use Liip\ValidationServiceBundle\Results\ValidationMessage;
use Liip\ValidationServiceBundle\Results\ValidationResult;
use Liip\ValidationServiceBundle\Helper\DocumentWrapper;
use Liip\ValidationServiceBundle\Filters\IFilter;


require_once 'Services/W3C/CSSValidator.php';

/**
 * @see IMarkupValidator
 * @author Daniel Barsotti
 */
class W3CCssValidationService extends AbstractValidationService
{
    protected $validator_service = null;

    public function __construct(IFilter $filter = null)
    {
        parent::__construct($filter);
        
        $this->validator_service = new \Services_W3C_CSSValidator();
    }

    /**
     * Return the availability of the validation service
     * @return boolean
     */
    public function isReady()
    {
        try {
            $res = $this->validator_service->validateFragment('test { }');
            return true;
        } catch (\Services_W3C_CSSValidator_Exception $e) {
            return false;
        }
    }

    /**
     * Validate a web page given its URI
     * @param string $uri
     * @return array
     */
    public function validateUri($uri)
    {
        $res = $this->validator_service->validateUri($uri);
        return $this->buildResults($res);
    }

    /**
     * Validate a complete HTML document
     * @param string $html
     * @return array
     */
    public function validateString($html)
    {
        $res = $this->validator_service->validateFragment($html);
        return $this->buildResults($res);
    }
    
    /**
     * Transform the response of the validator service to a valid IMarkupValidator return array
     * @param \Services_W3C_HTMLValidator_Response $res
     * @return array
     */
    protected function buildResults($res)
    {
        if (!$res instanceof  \Services_W3C_CSSValidator_Response) {
            return false;
        }

        $messages = array();
        foreach ($res->errors as $row) {
            $msg = new ValidationMessage($row->line, 0, $row->message, '', 'error');
            $messages[] = $msg;
        }
        foreach ($res->warnings as $row) {
            $msg = new ValidationMessage($row->line, 0, $row->message, '', 'warning');
            $messages[] = $msg;
        }

        $result = new ValidationResult(false, $messages);
        $this->filterResults($result);
        $result->setIsValid($res->isValid() || count($result->getMessages()) === 0);
        return $result;
    }

}
