<?php
/************************************************************************************
* Name:				Index Controller												*
* File:				Application\Controller\IndexController.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the home page's controller.								*
*																					*
* Creation Date:	16/07/2014														*
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace Application\Controller;

	use SaSeed\View;
	use Application\Controller\Service\User as UserService;
	use Application\Model\Index as ModIndex;

	class IndexController {

		public function __construct() {
			// Define JSs e CSSs utilizados por este controller
			//$GLOBALS['this_js']		= ''.PHP_EOL;	// Se não houver, definir como vazio ''
			//$GLOBALS['this_css']	= ''.PHP_EOL;	// Se não houver, definir como vazio ''
			// Define Menus a serem utilizados
			//$GLOBALS['mainMenu']		= file_get_contents(APP_PATH.'Application/View/partial/mainMenu.html');
			//$GLOBALS['rodape']		= file_get_contents(APP_PATH.'Application/View/partial/rodape_contato.html');
		}

		/*
		Prints out main home page - start()
			@return format	- print
		*/
		public static function index() {
			$ModIndex	= new ModIndex();
			$data		= 'Conteúdo da home';
			$content	= $ModIndex->modelate($data);
			View::set('content', $content);
			View::render('index');
		}

		public static function testInsert() {
			$userService = new UserService();

			$userArray["name"] = "Nome teste";
			$userArray["email"] = "emailteste@teste.com";
			$userArray["password"] = "abc123";

			$data = $userService->saveNewUser($userArray);
			
			View::set('content', 'id do usuario criado: ' . $data);
			View::render('index');
		}

		public static function testRead() {
			$userService = new UserService();
			$ModIndex	= new ModIndex();
			$user = $userService->getByEmail("emailteste@teste.com");
			$content = $ModIndex->modelUser($user);
			View::set('content', $content);
			View::render('index');
		}

		public static function testUpdate() {
			$userService = new UserService();
			$ModIndex	= new ModIndex();
			$user = $userService->getByEmail("emailteste@teste.com");
			$user->setName("Alterado");
			$data = $userService->updateUser($user);
			$user = $userService->getByEmail("emailteste@teste.com");
			$content = $ModIndex->modelUser($user);
			View::set('content', $content);
			View::render('index');
		}

		public static function testDelete() {
			$userService = new UserService();
			$ModIndex	= new ModIndex();
			$user = $userService->getByEmail("emailteste@teste.com");
			$content = $ModIndex->modelDelete($userService->deleteUser($user));
			View::set('content', $content);
			View::render('index');
		}
	}
