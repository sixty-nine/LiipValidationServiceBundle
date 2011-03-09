<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
        $form = ValidationForm::create($this->get('form.context'), 'validation');

        $form->bind($this->container->get('request'), $form);
        if ($form->isValid()) {

            $services = array(
                'xhtml' => 'markup.w3c',
                'html5' => 'markup.html5',
                'css' => 'css.w3c',
                'js' => 'javascript.jsl',
            );

            if (array_key_exists($form->validator, $services)) {
                $validator = $this->container->get("liip_validation_service.services." .$services[$form->validator]);
            } else {
                $validator = $this->container->get("liip_validation_service.services.markup.html5");
            }
            
            $res = $validator->validateString($form->document);
        }

        return array('form' => $form, 'results' => isset($res) ? $res : null);
    }

}
