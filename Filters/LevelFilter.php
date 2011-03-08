<?php

namespace Liip\ValidationServiceBundle\Filters;

use Liip\ValidationServiceBundle\Results\ValidationMessage;

class LevelFilter implements IFilter
{
    protected $ignored_levels = array();

    public function __construct($ignored_levels = array())
    {
        $this->ignored_levels = $ignored_levels;
    }

    public function filter(ValidationMessage $message)
    {
        foreach($this->ignored_levels as $level) {
            if ($level === $message->getLevel()) {
                return false;
            }
        }
        
        return true;
    }
}