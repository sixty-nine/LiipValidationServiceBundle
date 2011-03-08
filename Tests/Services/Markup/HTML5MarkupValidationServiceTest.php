<?php

namespace Liip\ValidationServiceBundle\Tests;

use Liip\ValidationServiceBundle\Filters;
use Liip\ValidationServiceBundle\Services;
use Liip\ValidationServiceBundle\Helper\DocumentWrapper;

class HTML5MarkupValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $service = new Services\Markup\HTML5MarkupValidationService();
    }

    public function testValidateString()
    {
        $service = new Services\Markup\HTML5MarkupValidationService();
        $res = $service->validateString(DocumentWrapper::wrap('<h1>Hello test</h1>', DocumentWrapper::HTML5_WRAPPER));
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

    public function testIsReady()
    {
        $service = new Services\Markup\HTML5MarkupValidationService();
        $this->assertTrue($service->isReady());

        $service->setValidatorUri('invalid_uri');
        $this->assertFalse($service->isReady());
        $this->assertAttributeEquals('invalid_uri', 'service_uri', $service);
    }

    public function testValidation()
    {
        $filter = new Filters\LevelFilter(array('info', 'warning'));
        $service = new Services\Markup\HTML5MarkupValidationService($filter);
        $res = $service->validateUri('http://html5demos.com/contenteditable');
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

    public function testResultFiltering()
    {
        $filter = new Filters\RegExpFilter(array('/element/'));
        $error_filter = new Filters\LevelFilter(array('error'));

        $service = new Services\Markup\HTML5MarkupValidationService();
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertFalse($res->getIsValid());
        $this->assertEquals(3, count($res->getMessages()));
        $message = $res->getMessages();
        $message = $message[0];
        $this->assertNotEquals(0, preg_match('/element/', $message->getMessage()));

        $service = new Services\Markup\HTML5MarkupValidationService($filter);
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertFalse($res->getIsValid());
        $this->assertEquals(1, count($res->getMessages()));
        $message = $res->getMessages();
        $message = $message[0];
        $this->assertEquals(0, preg_match('/element/', $message->getMessage()));

        $service = new Services\Markup\HTML5MarkupValidationService($error_filter);
        $res = $service->validateString('<!DOCTYPE html><html><head><title/></head><body><h1>Hello test</h1>');
        $this->assertTrue($res->getIsValid());
        $this->assertEmpty($res->getMessages());
    }

}