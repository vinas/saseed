<?php
/**
* Bootstrap
*
* This file loads basic Settings and starts up the right
* Controller for and Action Function.	
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2012/11/15
* @version 1.15.1021
* @license SaSeed\license.txt
*/

namespace SaSeed;

use SaSeed\URLRequest;

require_once('Settings.php'); // (Must be the first include)
require_once("autoload.php");

// ********************************************** \\
//	Load Specific Controller and Action Function  \\
// ********************************************** \\
$URLRequest = new URLRequest();
$controller = "\Application\Controller\\".$URLRequest->getController();
$actionFunction	= $URLRequest->getActionFunction();
$obj = new $controller;
$obj->$actionFunction();
