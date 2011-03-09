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

class FilterChain implements IFilter
{
    protected $filters = array();

    public function addFilter(IFilter $filter)
    {
        $this->filters[] = $filter;
    }

    public function filter(ValidationMessage $message)
    {
        foreach($this->filters as $filter)
        {
            if (! $filter->filter($message)) {
                return false;
            }
        }
        return true;
    }


}