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
 * ValidationMessage filter to ignore messages of given levels
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
class LevelFilter implements IFilter
{
    /**
     * @var array[string]
     */
    protected $ignored_levels = array();

    /**
     * @param array[string] $ignored_levels
     */
    public function __construct($ignored_levels = array())
    {
        $this->ignored_levels = $ignored_levels;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ValidationMessage $message)
    {
        foreach($this->ignored_levels as $level) {
            if ($level === $message->getLevel()) {
                return false;
            }
        }
        
        return true;
    }
}