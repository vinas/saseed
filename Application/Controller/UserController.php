<?php
/************************************************************************************
* Name:				Users' Controller												*
* File:				Application\Controller\UserController.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the user page's controller.								*
*																					*
* Creation Date:	14/11/2012														*
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace Application\Controller;

	use SaSeed\View;

	use Application\Model\User					as ModUser;
	use Application\Controller\Repository\User	as RepUser;

	class UserController {

		public function __construct() {
			// Define JSs e CSSs utilizados por este controller
			$GLOBALS['this_js']	= ''.PHP_EOL;	// Se não houver, definir como vazio ''
			$GLOBALS['this_css']	= ''.PHP_EOL;	// Se não houver, definir como vazio ''
			// Define Menus a serem utilizados
			$GLOBALS['mainMenu']		= file_get_contents(APP_PATH.'Application/View/partial/mainMenu.html');
			//$GLOBALS['rodape']		= file_get_contents(APP_PATH.'Application/View/partial/rodape_contato.html');
		}

		/*
		Prints out main home page - start()
			@return format	- print
		*/
		public static function index() {
			// Call in classes
			$ModUser	= new ModUser();
			$RepUser	= new RepUser();
			// Get all users on the database
			$users		= $RepUser->getAll();
			$content	= $ModUser->userList($users);
			View::set('content', $content);
			View::render('testeUser');
		}
	}