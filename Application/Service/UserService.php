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

use Application\Factory\UserFactory;

class UserService {

	private $factory;

	public function __construct()
	{
		$this->factory = new UserFactory();
	}

	public function save($user)
	{
		try {
			if ($this->isUserValid($user)) {
				if ($user->getId() > 0) {
					$this->factory->update($user);
				} else {
					$user = $this->factory->saveNew($user);
				}
			}
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $user;
		}
	}

	public function listUsers()
	{
		$list = [];
		try {
			$list = $this->factory->listAllOrderByName();
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $list;
		}
	}

	public function getUserById($userId = false)
	{
		$user = false;
		try {
			if ($userId)
				$user = $this->factory->getById($userId);
			if (isset($user->id) && $user->getId() == false)
				$user = false;
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $user;
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
		if (!is_object($user)){
			return false;
		}
		if (strlen($user->getName()) < 1){
			return false;
		}
		if (strlen($user->getEmail()) < 1){
			return false;
		}
		return true;
	}

}
