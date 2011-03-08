<?php

namespace Liip\ValidationServiceBundle\Tests;

use Liip\ValidationServiceBundle\Filters;
use Liip\ValidationServiceBundle\Results\ValidationMessage;

class LevelFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $filter = new Filters\LevelFilter();
        $this->assertAttributeEquals(array(), 'ignored_levels', $filter);

        $filter = new Filters\LevelFilter(array('error', 'warning'));
        $this->assertAttributeEquals(array('error', 'warning'), 'ignored_levels', $filter);
    }

    public function testFilter()
    {
        $error = new ValidationMessage(0, 0, 'whatever', 'something', 'error');
        $warning = new ValidationMessage(0, 0, 'whatever', 'something', 'warning');
        $info = new ValidationMessage(0, 0, 'whatever', 'something', 'info');

        $filter = new Filters\LevelFilter(array('error'));
        $this->assertFalse($filter->filter($error));
        $this->assertTrue($filter->filter($warning));
        $this->assertTrue($filter->filter($info));

        $filter = new Filters\LevelFilter(array('error', 'warning'));
        $this->assertFalse($filter->filter($error));
        $this->assertFalse($filter->filter($warning));
        $this->assertTrue($filter->filter($info));

        $filter = new Filters\LevelFilter(array('error', 'warning', 'info'));
        $this->assertFalse($filter->filter($error));
        $this->assertFalse($filter->filter($warning));
        $this->assertFalse($filter->filter($info));
    }
}