<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Results;

use Liip\ValidationServiceBundle\Filters\IFilter;

class ValidationResult
{
    protected $is_valid = false;
    protected $messages = array();

    public function __construct($is_valid = false, $messages = array())
    {
        $this->is_valid = $is_valid;
        $this->messages = $messages;
    }

    public function getIsValid()
    {
        return $this->is_valid;
    }

    public function setIsValid($val)
    {
        $this->is_valid = $val;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(ValidationMessage $message)
    {
        $this->messages[] = $message;
    }
    
    public function filter(IFilter $filter)
    {

        for($i = count($this->messages) - 1; $i >= 0; $i--) {

            if (! $filter->filter($this->messages[$i])) {

                unset($this->messages[$i]);
            }

        }

    }

}