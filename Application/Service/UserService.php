<?php
/**
* User Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.1026
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;
use SaSeed\Handlers\Mapper;

use Application\Factory\UserFactory;
use Application\Service\ResponseHandlerService;
use Application\Model\UserResponseModel;
use Application\Model\UsersListResponseModel;

class UserService {

	private $factory;

	public function __construct()
	{
		$this->factory = new UserFactory();
	}

	public function save($user)
	{
		$responseHandler = new ResponseHandlerService();
		$mapper = new Mapper();
		$res = new UserResponseModel();
		try {
			if ($this->isUserValid($user)) {
				$user->setPassword($this->encrypt($user->getPassword()));
				if ($user->getId() > 0) {
					$this->factory->update($user);
				} else {
					$user = $this->factory->saveNew($user);
				}
				$res = $mapper->populate(
						$res,
						$user
					);
				$res = $responseHandler->handleResponse($res, 200);
			} else {
				$res = $responseHandler->handleResponse($res, 100);
			}
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
			$res = $responseHandler->handleResponse($res, 101);
		} finally {
			return $res;
		}
	}

	public function listUsers()
	{
		$res = [];
		try {
			$mapper = new Mapper();
			$users = $this->factory->listAll();
			foreach ($users as $user) {
				$res[] = $mapper->populate(new UsersListResponseModel(), $user);
			}
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $res;
		}
	}

	public function getUserById($userId = false)
	{
		$responseHandler = new ResponseHandlerService();
		$mapper = new Mapper();
		$res = new UserResponseModel();
		try {
			if ($userId) {
				$user = $this->factory->getById($userId);
				if ($user->getId() > 0 && is_numeric($user->getId())) {
					$res = $mapper->populate(
							$res,
							$user
						);
					$res = $responseHandler->handleResponse($res, 201);
				} else {
					$res = $responseHandler->handleResponse($res, 102);
				}
			} else {
				$res = $responseHandler->handleResponse($res, 103);
			}
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
			$res = $responseHandler->handleResponse($res, 102);
		} finally {
			return $res;
		}
	}

	public function delete($userId)
	{
		try {
			$this->factory->deleteUserById($userId);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	private function isUserValid($user)
	{
		if (strlen($user->getUser()) < 1) {
			return false;
		} else if (strlen($user->getEmail()) < 1) {
			return false;
		} else if (strlen($user->getPassword()) < 1) {
			return false;
		}
		return true;
	}

	private function encrypt($txt)
	{
		return md5($txt);
	}

}
