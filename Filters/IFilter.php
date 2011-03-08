<?php

namespace Liip\ValidationServiceBundle\Filters;

use Liip\ValidationServiceBundle\Results\ValidationMessage;

interface IFilter
{
    /**
     * Filter error messages. Return false when the message must be ignored.
     * @param ValidationMessage $message;
     * @return boolean
     */
    public function filter(ValidationMessage $message);
}