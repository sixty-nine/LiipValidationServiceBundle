<?php

namespace Liip\ValidationServiceBundle\Results;

class ValidationMessage
{
    const ERROR_MESSAGE = 'error';
    const WARNING_MESSAGE = 'warning';
    const INFO_MESSAGE = 'info';

    protected $line;
    protected $column;
    protected $source;
    protected $message;
    protected $level;

    public function __construct($line = 0, $column = 0, $message = '', $source = '', $level = ValidationMessage::INFO_MESSAGE)
    {
        $this->line = $line;
        $this->column = $column;
        $this->message = $message;
        $this->source = $source;
        $this->level = $level;
    }

    public function setLine($val)
    {
        $this->line = $val;
    }

    public function setColumn($val)
    {
        $this->column = $val;
    }

    public function setMessage($val)
    {
        $this->message = $val;
    }

    public function setSource($val)
    {
        $this->source = $val;
    }

    public function setLevel($val)
    {
        $this->level = $val;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getLevel()
    {
        return $this->level;
    }
}