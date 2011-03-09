<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Filters;

use Liip\ValidationServiceBundle\Results\ValidationMessage;

/**
 * ValidationMessage filter to ignore messages based on regular expressions appied to either the
 * source code or the message itself
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
class RegExpFilter implements IFilter
{
    /**
     * @var array[string]
     */
    protected $regexp_list = array();

    /**
     * @var string
     */
    protected $filter_on = 'message';

    /**
     * @param array[string] $regexp_list
     * @param string $filter_on Apply the filter either on the 'message' or the 'source'
     */
    public function __construct($regexp_list = array(), $filter_on = 'message')
    {
        $this->regexp_list = $regexp_list;
        $this->filter_on = $filter_on;
    }

    /**
     * Add a new regexp to the filter
     * @param string $regexp
     */
    public function addRegExp($regexp)
    {
        $this->regexp_list[] = $regexp;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ValidationMessage $message)
    {
        if ($this->filter_on === 'message') {
            $subject = $message->getMessage();
        } elseif($this->filter_on === 'source') {
            $subject = $message->getSource();
        } else {
            throw new \InvalidArgumentException("Invalid filter on '{$this->filter_on}'");
        }

        foreach($this->regexp_list as $regexp) {
            if(preg_match($regexp, $subject)) {
                return false;
            }
        }

        return true;
    }
}