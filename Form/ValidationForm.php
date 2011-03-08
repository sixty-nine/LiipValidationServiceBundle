<?php

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
