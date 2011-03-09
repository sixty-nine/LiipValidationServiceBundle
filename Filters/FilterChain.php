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
 * Composite ValidationMessage filter allowing to apply several filters to the messages
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
class FilterChain implements IFilter
{
    /**
     * @var array[IFilter]
     */
    protected $filters = array();

    /**
     * Add a new filter to the filter chain
     * @param IFilter $filter
     */
    public function addFilter(IFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * {@inheritdoc}
     */
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