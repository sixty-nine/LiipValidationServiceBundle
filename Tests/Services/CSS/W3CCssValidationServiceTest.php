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

class W3CCSSValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $service = new Services\Css\W3CCssValidationService();
        $this->assertAttributeEquals(new \Services_W3C_CSSValidator(), 'validator_service', $service);
    }

    public function testIsReady()
    {
        $service = new Services\Css\W3CCssValidationService();
        $this->assertTrue($service->isReady());
    }

    public function testValidateUri()
    {
        $service = new Services\Css\W3CCssValidationService();
        $res = $service->validateUri('http://google.ch/');
        // TODO: finish...
    }
}