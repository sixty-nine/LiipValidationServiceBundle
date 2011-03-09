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

use Liip\ValidationServiceBundle\Filters;
use Liip\ValidationServiceBundle\Results\ValidationMessage;

class FilterChainTest extends \PHPUnit_Framework_TestCase
{
    protected $regexp_filter;
    protected $level_filter;

    public function setUp()
    {
        $this->regexp_filter = new Filters\RegExpFilter(array('/foo/', '/bar/'));
        $this->level_filter = new Filters\LevelFilter(array('info', 'warning'));
    }

    public function testConstructor()
    {
        $chain = new Filters\FilterChain();
        $this->assertAttributeEquals(array(), 'filters', $chain);
    }

    public function testAddFilter()
    {
        $chain = new Filters\FilterChain();
        $this->assertAttributeEquals(array(), 'filters', $chain);

        $chain->addFilter($this->regexp_filter);
        $this->assertAttributeEquals(array($this->regexp_filter), 'filters', $chain);

        $chain->addFilter($this->level_filter);
        $this->assertAttributeEquals(array($this->regexp_filter, $this->level_filter), 'filters', $chain);
    }

    public function testFilter()
    {
        $foo = new ValidationMessage(0, 0, 'foo', 'something', 'error');
        $bar = new ValidationMessage(0, 0, 'bar', 'something', 'warning');
        $foobar = new ValidationMessage(0, 0, 'foobar', 'something', 'info');

        $chain = new Filters\FilterChain();
        $this->assertTrue($chain->filter($foo));
        $this->assertTrue($chain->filter($bar));
        $this->assertTrue($chain->filter($foobar));

        $chain->addFilter($this->regexp_filter);
        $this->assertFalse($chain->filter($foo));
        $this->assertFalse($chain->filter($bar));
        $this->assertFalse($chain->filter($foobar));

        $chain = new Filters\FilterChain();
        $chain->addFilter($this->level_filter);
        $this->assertTrue($chain->filter($foo));
        $this->assertFalse($chain->filter($bar));
        $this->assertFalse($chain->filter($foobar));

        $chain = new Filters\FilterChain();
        $chain->addFilter($this->level_filter);
        $chain->addFilter($this->regexp_filter);
        $this->assertFalse($chain->filter($foo));
        $this->assertFalse($chain->filter($bar));
        $this->assertFalse($chain->filter($foobar));
    }
}