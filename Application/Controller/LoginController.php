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
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Controller\Service\User as UserService;
use Application\Controller\Service\Session as SessionService;
use Application\Model\Index as ModIndex;

class LoginController {

	public function __construct() {
		Session::start();
	}

	public static function index() {
		View::render('login');
	}

	public static function in() {
		$URLRequest = new URLRequest();
		$userService = new UserService();
		$sessionService = new SessionService();
		$params = $URLRequest->getPostParams();
		//$user = $userService->findUserByLogin($param['user'], md5($params['password']));
		$user = $userService->findUserByLogin($param['user'], $params['password']);
		if ($user) {
			$sessionKey = $sessionService->generateSessionKey($user);
			$sessionService->setUserSession($user, $sessionKey);
			View::redirect('Index');
		} else {
			$response['response'] = 0;
			$response['message'] = $GLOBALS['exceptions']['GENERAL']['userPassNotMatch'];
			View::jsonEncode($response); 
		}
	}

}