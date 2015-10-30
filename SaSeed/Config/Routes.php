<?php
/**
* General Routes
*
* This file holds basic route settings for the whole application.
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/08/28
* @version 1.15.0828
* @license SaSeed\license.txt
*/

// WEB CONTEXT ROUTES
define('WebJSViewPath', '/Application/View/Js/');
define('WebCSSViewPath', '/Application/View/Css/');

// LOCAL ROUTES
$path = dirname(__FILE__);
$basePath = substr($path, 0, strpos($path, 'SaSeed'));
define('ConfigPath', $basePath.'SaSeed'.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR);
define('ViewPath', $basePath.'Application'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR);
define('TemplatesPath', $basePath.'Application'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR);
define('GeneralJSPath', ViewPath.'Js'.DIRECTORY_SEPARATOR);
define('GeneralCSSPath', ViewPath.'Css'.DIRECTORY_SEPARATOR);
