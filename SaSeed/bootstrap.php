<?php
/************************************************************************************
* Name:				Bootstrap														*
* File:				SaSeed\bootstrap.php 											*
* Author(s):		Vinas de Andrade e Leandro Menezes								*
*																					*
* Description: 		This file loads basic Settings and starts up the right			*
*					Controller for and Action Function.								*
*																					*
* Creation Date:	15/11/2012														*
* Version:			1.13.0523														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	// Define Charset
	header('Content-type: text/html; charset=UTF-8');

	// *********************** \\
	//	Define Basic settings  \\
	// *********************** \\
	require_once('Settings.php'); // (Must be the first include)
	require_once("autoload.php");

	// *********************** \\
	//  Include Basic Classes
	// *********************** \\
	
	require_once(APP_PATH.'SaSeed/Session.php');
	
	// Database Connection
	if (DB_NAME) {
		$db	= new Database();
		$db->DBConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	// Define General JSs
	$GLOBALS['general_js']	= '<script type="text/javascript" src="/Application/Js/libs/jquery-1.7.1.min.js"></script>'.PHP_EOL;	// Se não houver, definir como vazio ''
	$GLOBALS['general_js']	.= '<script type="text/javascript" src="/Application/Js/libs/scripts.js"></script>'.PHP_EOL;	// Se não houver, definir como vazio ''

	// Define General CSSs
	$GLOBALS['general_css']	= '<link href="/Application/Css/jquery.fancybox-1.3.4.css" rel="stylesheet">'.PHP_EOL;	// Se não houver, definir como vazio ''
	$GLOBALS['general_css']	.= '<link href="/Application/Css/main_styles.css" rel="stylesheet">'.PHP_EOL;	// Se não houver, definir como vazio ''

	// ********************************************** \\
	//	Load Specific Controller and Action Function  \\
	// ********************************************** \\

	// Define Controller, Action and Parameters
	$URLparams					= new URLRequest();
	$GLOBALS['controller_name']	= $URLparams->getController();
	$GLOBALS['controller']		= "\Application\Controller\\".$URLparams->getController();
	$GLOBALS['action_function']	= $URLparams->getActionFunction();
	$GLOBALS['params']			= $URLparams->getParams();

	// Call in Controller and Functions whithin proper environment
	$obj = new $GLOBALS['controller'];
	$obj->$GLOBALS['action_function']();


