<?php

/*
 * This file is part of the Liip/ValidationServiceBundle
 *
 * Copyright (c) 2010-2011 Liip
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ValidationServiceBundle\Helper;

class DocumentWrapper {

    /**
     * Basic HTML5 wrapper
     */
    const HTML5_WRAPPER = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
</head>
<body>
<<CONTENT>>
</body>
</html>
HTML;

    /**
     * Basic XHTML 1.0 wrapper
     */
    const XHTML_STRICT_WRAPPER = <<<'HTML'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<body><<CONTENT>></body>
</html>
HTML;

    public static function wrap($fragment, $template)
    {
        return str_replace('<<CONTENT>>', $fragment, $template);
    }

}