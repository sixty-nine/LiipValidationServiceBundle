<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Services\Javascript;

use Liip\ValidationServiceBundle\Services\AbstractValidationService;
use Liip\ValidationServiceBundle\Results\ValidationMessage;
use Liip\ValidationServiceBundle\Results\ValidationResult;
use Liip\ValidationServiceBundle\Helper\DocumentWrapper;
use Liip\ValidationServiceBundle\Filters\IFilter;

/**
 * EXPERIMENTAL !!!
 *
 * @see IMarkupValidator
 * @author Daniel Barsotti
 */
class JavascriptLintValidationService extends AbstractValidationService
{
    protected $jsl_executable;

    public function __construct(IFilter $filter = null)
    {
        parent::__construct($filter);
        $this->jsl_executable = realpath(__DIR__.'/../../Resources/bin').'/jsl';
    }

    /**
     * Return the availability of the validation service
     * @return boolean
     */
    public function isReady()
    {
        return \file_exists($this->jsl_executable);
    }

    /**
     * @param string $uri
     * @return array
     */
    public function validateUri($uri)
    {
        throw new \Exception('NOT YET IMPLEMENTED');
    }

    /**
     * @param string $html
     * @return array
     */
    public function validateString($html)
    {
        // TODO: create the temp file in the app cache
        $tmpfile = '/tmp/'.uniqid();
        $command = $this->jsl_executable . ' -process ' . $tmpfile;

        file_put_contents($tmpfile, $html);
        exec($command, $output, $return);
        unlink($tmpfile);

        return $this->buildResults($tmpfile, $output, $return);
    }

    protected function buildResults($tmpfile, $output, $return)
    {
//  0 - Success
//  1 - JavaScript warnings
//  2 - Usage or configuration error
//  3 - JavaScript error
//  4 - File error
// string(54) "/tmp/4d76b6098cea1(4): lint warning: missing semicolon"
// string(62) "/tmp/4d76b62d1b070(1): SyntaxError: missing ; before statement"

        if (! is_array($output)) {
            return false;
        }

        $messages = array();

        foreach($output as $line) {
            // TODO: rewrite parsing
            if (substr($line, 0, strlen($tmpfile)) == $tmpfile) {
                if (preg_match('/SyntaxError/', $line)) {
                    $level = 'error';
                } elseif (\preg_match('/lint warning/', $line)) {
                    $level = 'warning';
                } else {
                    $level = 'info';
                }
                $messages[] = new ValidationMessage(0, 0, $line, '', $level);
            }
        }

        $res = new ValidationResult($return === 0, $messages);
        $this->filterResults($res);
        return $res;
    }
}