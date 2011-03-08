<?php

namespace Liip\ValidationServiceBundle\Tests;

use Liip\ValidationServiceBundle\Filters;
use Liip\ValidationServiceBundle\Services;
use Liip\ValidationServiceBundle\Helper\DocumentWrapper;

class W3CMarkupValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $service = new Services\Markup\W3CMarkupValidationService();
        $this->assertAttributeEquals(new \Services_W3C_HTMLValidator(), 'validator_service', $service);
    }

    public function testIsReady()
    {
        $service = new Services\Markup\W3CMarkupValidationService();
        $this->assertTrue($service->isReady());

        $service->setValidatorUri('invalid_uri');
        $this->assertFalse($service->isReady());
    }

    public function testValidateString()
    {
        $service = new Services\Markup\W3CMarkupValidationService();
        $res = $service->validateString(DocumentWrapper::wrap('<h1>Hello test</h1>', DocumentWrapper::XHTML_STRICT_WRAPPER));
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

    public function testValidation()
    {
        $service = new Services\Markup\W3CMarkupValidationService();
        $res = $service->validateUri('http://www.webstandards.org/files/acid2/reference.html');
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

    public function testResultFiltering()
    {
        $filter = new Filters\RegExpFilter(array('/element/'));
        $error_filter = new Filters\LevelFilter(array('error'));

        $service = new Services\Markup\W3CMarkupValidationService();
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertFalse($res->getIsValid());
        $this->assertEquals(3, count($res->getMessages()));
        $message = reset($res->getMessages());
        $this->assertNotEquals(0, preg_match('/element/', $message->getMessage()));

        $service = new Services\Markup\W3CMarkupValidationService($filter);
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertFalse($res->getIsValid());
        $this->assertEquals(1, count($res->getMessages()));
        $message = reset($res->getMessages());
        $this->assertEquals(0, preg_match('/element/', $message->getMessage()));

        $service = new Services\Markup\W3CMarkupValidationService($error_filter);
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

}