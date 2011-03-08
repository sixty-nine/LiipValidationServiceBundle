<?php

namespace Liip\ValidationServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Liip\ValidationServiceBundle\Form\ValidationForm;
use Liip\ValidationServiceBundle\Services;

class DemoController extends Controller
{
    /**
     * @extra:Route("/")
     * @extra:Template()
     */
    public function indexAction()
    {
        $form = ValidationForm::create($this->get('form.context'), 'contact');

        $form->bind($this->container->get('request'), $form);
        if ($form->isValid()) {

            switch($form->validator) {
                case 'xhtml':
                    $validator = new Services\Markup\W3CMarkupValidationService();
                    break;
                case 'css':
                    $validator = new Services\Css\W3CCssValidationService();
                    break;
                case 'js':
                    $validator = new Services\Javascript\JavascriptLintValidationService();
                    break;
                case 'html5':
                default:
                    $validator = new Services\Markup\HTML5MarkupValidationService();
                    break;
            }

            
            $res = $validator->validateString($form->document);
        }

        return array('form' => $form, 'results' => isset($res) ? $res : null);
    }

}
