<?php

namespace Liip\ValidationServiceBundle\Filters;

use Liip\ValidationServiceBundle\Results\ValidationMessage;

class RegExpFilter implements IFilter
{
    protected $regexp_list = array();
    protected $filter_on = 'message';

    public function __construct($regexp_list = array(), $filter_on = 'message')
    {
        $this->regexp_list = $regexp_list;
        $this->filter_on = $filter_on;
    }

    public function addRegExp($regexp)
    {
        $this->regexp_list[] = $regexp;
    }

    public function filter(ValidationMessage $message)
    {
        if ($this->filter_on === 'message') {
            $subject = $message->getMessage();
        } elseif($this->filter_on === 'source') {
            $subject = $message->getSource();
        } else {
            throw new \InvalidArgumentException("Invalid filter on '{$this->filter_on}'");
        }

        foreach($this->regexp_list as $regexp) {
            if(preg_match($regexp, $subject)) {
                return false;
            }
        }

        return true;
    }
}