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

// @codeCoverageIgnoreStart

/**
 * Interface for validation services.
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
interface IValidationService
{

    /**
     * Indicate if the validation service is available
     * @return boolean
     */
    function isReady();

    /**
     * Validate a given URI
     * @param string $uri The URI to validate
     * @return ValidationResult
     */
    function validateUri($uri);

    /**
     * Validate a string
     * @param string $html The string to validate
     * @return ValidationResult
     */
    function validateString($html);

    /**
     * Return the default wrapper to transform a document fragment into a valid full document
     */
    function getDefaultFragmentWrapper();

}
// @codeCoverageIgnoreEnd
