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

class UserService {

	private $factory;

	public function __construct()
	{
		$this->factory = new UserFactory();
	}

	public function save($user)
	{
		$responseHandler = new ResponseHandlerService();
		$res = new UserResponseModel();
		try {
			if ($this->isUserValid($user)) {
				if ($user->getId() > 0) {
					$this->factory->update($user);
				} else {
					$user = $this->factory->saveNew($user);
				}
				$res = Mapper::populate(
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
			$res = $this->factory->listAll();
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $res;
		}
	}

	public function getUserById($userId = false)
	{
		$responseHandler = new ResponseHandlerService();
		$res = new UserResponseModel();
		try {
			if ($userId) {
				$user = $this->factory->getById($userId);
				if ($user->getId() > 0 && is_numeric($user->getId())) {
					$res = Mapper::populate(
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
		if (strlen($user->getName()) < 1)
			return false;
		if (strlen($user->getEmail()) < 1)
			return false;
		return true;
	}

	private function encrypt($txt)
	{
		return md5($txt);
	}

}
