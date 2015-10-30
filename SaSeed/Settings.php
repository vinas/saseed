<?php
/**
* General Settings
*
* This file holds basic settings for the whole application.
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @author Leandro Menezes
* @author Raphael Pawlik
* @since 2012/11/14
* @version 2.15.1021
* @license SaSeed\license.txt
*/

// DEBUG
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Charset Definition
header('Content-type: text/html; charset=UTF-8');

//Routes
require('Config'.DIRECTORY_SEPARATOR.'Routes.php');


// Timezone and regional Defitions
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_MONETARY, 'pt_BR');
setlocale(LC_ALL, 'Portuguese_Brazil.1252 ');

// Exceptions Defition
$GLOBALS['exceptions'] = parse_ini_file(ConfigPath.'exceptions.ini', true);

// XSS String List
$GLOBALS['xssStrings'] = parse_ini_file(ConfigPath.'xss.ini');
