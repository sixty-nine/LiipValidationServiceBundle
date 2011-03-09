<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\ChoiceField;

class ValidationForm extends Form
{
    public $validator;
    public $document;

    public function configure()
    {
        $validators = array(
            'xhtml' => 'W3C Markup',
            'html5' => 'HTML5',
            'css' => 'W3C CSS',
            'js' => 'JavascriptLint (EXPERIMENTAL)',
        );
        $this->add(new ChoiceField('validator', array('choices' => $validators)));
        $this->add(new TextareaField('document'));
    }

}
