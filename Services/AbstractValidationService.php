<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Services;

use Liip\ValidationServiceBundle\Filters\IFilter;
use Liip\ValidationServiceBundle\Results\ValidationResult;

/**
 * Basic implementation of IValidationService providing validation messages filtering to the subclasses
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
abstract class AbstractValidationService implements IValidationService {

    protected $result_filter;

    /**
     * @param IFilter $filter Validation filter to apply to validation messages
     */
    public function __construct(IFilter $filter = null)
    {
        $this->result_filter = $filter;
    }

    function getDefaultFragmentWrapper()
    {
        return '';
    }

    /**
     * Filter the results of the validation with the validation filter
     *
     * @param ValidationResult $result
     */
    protected function filterResults(ValidationResult &$result)
    {
        if ($this->result_filter !== null) {
            $result->filter($this->result_filter);
        }
    }
}

