<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Results;

/**
 * A single validation message
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
class ValidationMessage
{
    /**
     * Message levels
     */
    const ERROR_MESSAGE = 'error';
    const WARNING_MESSAGE = 'warning';
    const INFO_MESSAGE = 'info';

    /**
     * @var integer
     */
    protected $line;

    /**
     * @var integer
     */
    protected $column;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
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