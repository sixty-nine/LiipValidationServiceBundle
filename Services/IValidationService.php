<?php

namespace Liip\ValidationServiceBundle\Services;

// @codeCoverageIgnoreStart
interface IValidationService
{

    /**
     * Indicate if the validation service is available
     * @return boolean
     */
    function isReady();

    /**
     * Validate a given URI
     * @param string $uri The URI of the page to validate
     * @return ValidationResult
     */
    function validateUri($uri);

    /**
     * Validate a string
     * @param string $html The complete HTML document
     * @return ValidationResult
     */
    function validateString($html);

}
// @codeCoverageIgnoreEnd
