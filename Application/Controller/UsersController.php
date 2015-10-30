<?php
/**
* Index Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.15.1026
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\View\View;
use SaSeed\URLRequest;

use SaSeed\Mapper as Mapper;
use Application\Model\User as UserModel;
use Application\Service\User as UserService;

class UsersController {

	private $params;
	private $service;
	private $classPath = "Application\Controller\UsersController";

	public function __construct() {
		$this->params = new URLRequest();
		$this->service = new UserService();
	}

	public function newUser() {
		try {
			View::set('user', new UserModel());
			View::set('page', 'newUser');
			View::render('userForm');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::newUser] - '. $e->getMessage());
		}
	}

	public function newUserJson() {
		try {
			View::set('user', new UserModel());
			View::set('page', 'newUserJson');
			View::render('userFormJson');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::newUserJson] - '. $e->getMessage());
		}
	}

	public function listUsers() {
		try {
			View::set('page', 'list');
			View::set('users', $this->service->listUsers());
			View::render('listUsers');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::newUser] - '. $e->getMessage());
		}
	}

	public function save() {
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			View::set('user', $this->service->save($user));
			View::render('userSaved');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::save] - '. $e->getMessage());
		}
	}

	public function saveJsonResponse() {
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			$this->service->save($user);
			$response['message'] = "User saved!";
		} catch (Exception $e) {
			throw('['.$this->classPath.'::saveJsonResponse] - '. $e->getMessage());
			$response['message'] = "User not saved!";
		}
		View::renderJson($response);
	}

	public function edit() {
		try {
			$params = $this->params->getParams();
			View::set('user', $this->service->getUserById($params[0]));
			View::render('userForm');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::newUser] - '. $e->getMessage());
		}
	}

	public function delete() {
		try {
			$params = $this->params->getParams();
			$this->service->delete($params[0]);
			View::redirect('/Users/listUsers', true);
		} catch (Exception $e) {
			throw('['.$this->classPath.'::delete] - '. $e->getMessage());
		}
	}
}
