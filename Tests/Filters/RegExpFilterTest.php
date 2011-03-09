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

class RegExpFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $filter = new Filters\RegExpFilter();
        $this->assertAttributeEquals(array(), 'regexp_list', $filter);
        $this->assertAttributeEquals('message', 'filter_on', $filter);

        $filter = new Filters\RegExpFilter(array('/foo/', '/bar/'), 'info');
        $this->assertAttributeEquals(array('/foo/', '/bar/'), 'regexp_list', $filter);
        $this->assertAttributeEquals('info', 'filter_on', $filter);
    }

    public function testAddRegExp()
    {
        $filter = new Filters\RegExpFilter();
        $this->assertAttributeEquals(array(), 'regexp_list', $filter);

        $filter->addRegExp('/foo/');
        $this->assertAttributeEquals(array('/foo/'), 'regexp_list', $filter);

        $filter->addRegExp('/bar/');
        $this->assertAttributeEquals(array('/foo/', '/bar/'), 'regexp_list', $filter);
    }

    public function testFilter()
    {
        $foo = new ValidationMessage(0, 0, 'foo', 'something', 'error');
        $bar = new ValidationMessage(0, 0, 'bar', 'something', 'warning');
        $foobar = new ValidationMessage(0, 0, 'foobar', 'something', 'info');
        
        $filter = new Filters\RegExpFilter(array('/foo/'));
        $this->assertFalse($filter->filter($foo));
        $this->assertTrue($filter->filter($bar));
        $this->assertFalse($filter->filter($foobar));

        $filter = new Filters\RegExpFilter(array('/bar/'));
        $this->assertTrue($filter->filter($foo));
        $this->assertFalse($filter->filter($bar));
        $this->assertFalse($filter->filter($foobar));

        $filter = new Filters\RegExpFilter(array('/foobar/'));
        $this->assertTrue($filter->filter($foo));
        $this->assertTrue($filter->filter($bar));
        $this->assertFalse($filter->filter($foobar));

        $filter = new Filters\RegExpFilter(array('/something/'), 'source');
        $this->assertFalse($filter->filter($foo));
        $this->assertFalse($filter->filter($bar));
        $this->assertFalse($filter->filter($foobar));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid filter on 'invalid'
     */
    public function testInvalidFilterOn()
    {
        $filter = new Filters\RegExpFilter(array('/foo/'), 'invalid');
        $filter->filter(new ValidationMessage(0, 0, 'foo', 'something', 'error'));
    }
}