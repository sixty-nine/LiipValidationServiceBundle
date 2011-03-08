<?php

namespace Liip\ValidationServiceBundle\Services;

use Liip\ValidationServiceBundle\Filters\IFilter;
use Liip\ValidationServiceBundle\Results\ValidationResult;

abstract class AbstractValidationService implements IValidationService {

    protected $result_filter;

    public function __construct(IFilter $filter = null)
    {
        $this->result_filter = $filter;
    }

    protected function filterResults(ValidationResult &$result)
    {
        if ($this->result_filter !== null) {
            $result->filter($this->result_filter);
        }
    }
}

