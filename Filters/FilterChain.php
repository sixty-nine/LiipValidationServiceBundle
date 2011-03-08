<?php

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