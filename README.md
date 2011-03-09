Introduction
============

THIS BUNDLE IS STILL IN DEVELOPMENT !!!

This Bundle provides interfaces to various services such as W3C and HTML5 markup validation and
W3C CSS validation.

Installation
------------

  1. Add this bundle to your project as Git submodules:

          $ git submodule add git@github.com:sixty-nine/LiipValidationServiceBundle.git

  2. Add this bundle to your application's kernel:

          // app/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Liip\ValidationServiceBundle\LiipValidationServiceBundle(),
                  // ...
              );
          }

  3. Add the Liip namespace to your autoload.php:

            // app/autoload.php
            $loader->registerNamespaces(array(
                // ...
                'Liip'                         => __DIR__.'/../src',
                // ...
            ));

  4. Configure the `ValidationService` services in your config:

          # app/config/config.yml
          liip_validation_service: ~

  5. Add the validation service demo routes

            # app/config/routing.yml
            _liip_validation_service_demo:
                resource: "@LiipValidationServiceBundle/Controller/DemoController.php"
                type:     annotation
                prefix:   /_validator

  6. Install Services_W3C_HTMLValidator and Services_W3C_CSSValidator pear packages

            pear install Services_W3C_HTMLValidator
            pear install Services_W3C_CSSValidator

  7. Optional: Install local copy of the HTML5 validator

        More information see below

  8. Optional: Installl local copy of the JavascriptLint validator

        More information see below


HTML5 validator
---------------

- The on-line validator: http://validator.nu/
- The documentation: http://about.validator.nu/
- Documentation about the web service: http://wiki.whatwg.org/wiki/Validator.nu_Web_Service_Interface

JavascriptLint validator
------------------------

- The documentation: http://www.javascriptlint.com/
- The download page: http://www.javascriptlint.com/download.htm

TODO
----

- JSLint validation service !
