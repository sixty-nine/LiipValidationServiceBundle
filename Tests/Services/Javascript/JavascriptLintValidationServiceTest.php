<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Tests;

use Liip\ValidationServiceBundle\Services;

class JavascriptLintValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $error_js = "\$var var test = 123;";
        $warning_js = "\$var; var test = 0.1234;\nvar test1 = parseInt(test);\nalert(test);\n{} var t";
        $valid_js = 'var t = 1;';

        $service = new Services\Javascript\JavascriptLintValidationService();
        $res = $service->validateString($warning_js);
        //var_dump($res);
    }
}