<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Filters;

use Liip\ValidationServiceBundle\Results\ValidationMessage;

/**
 * Filter ValidationMessage
 *
 * @author Daniel Barsotti <daniel.barsotti[at]liip.ch>
 * @copyright (c) 2010-2011 Liip
 */
interface IFilter
{
    /**
     * Filter error messages. Return false when the message must be ignored.
     * @param ValidationMessage $message;
     * @return boolean
     */
    public function filter(ValidationMessage $message);
}