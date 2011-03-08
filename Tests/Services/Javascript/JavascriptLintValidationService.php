<?php

namespace Liip\ValidationServiceBundle\Helper\Services\Javascript;

use Liip\ValidationServiceBundle\Services\AbstractValidationService;
use Liip\ValidationServiceBundle\Filters\IFilter;

/**
 * @see IMarkupValidator
 * @author Daniel Barsotti
 */
class JavascriptLintValidationService extends Service\AbstractValidationService
{
    protected $jsl_executable;

    public function __construct(IFilter $filter = null)
    {
        parent::__construct($filter);
        $this->jsl_executable = realpath(__DIR__.'/../../../../Resources/bin').'/jsl';
    }

    /**
     * Return the availability of the validation service
     * @return boolean
     */
    public function isReady()
    {
    }

    /**
     * @param string $uri
     * @return array
     */
    public function validateUri($uri)
    {
    }

    /**
     * @param string $html
     * @return array
     */
    public function validateString($html)
    {
    }
}