<?php
/**
* User Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.15.1026
* @license SaSeed\license.txt
*/

namespace Application\Service;

use Application\Repository\UserRepository;

class UserService {

	private $repository;

	public function __construct()
	{
		$this->repository = new UserRepository();
	}

	public function save($user)
	{
		if ($user->getId() > 0) {
			$this->repository->update($user);
		} else {
			$user = $this->repository->saveNew($user);
		}
		return $user;
	}

	public function listUsers()
	{
		try {
			return $this->repository->listAll();
		} catch (Exception $e) {
			throw('['.$this->classPath.'::listUsers] - '.  $e->getMessage());
		}
	}

	public function getUserById($userId)
	{
		try {
			return $this->repository->getById($userId);
		} catch (Exception $e) {
			throw('['.$this->classPath.'::getUserById] - '.  $e->getMessage());
		}
	}

	public function delete($userId)
	{
		try {
			return $this->repository->deleteUserById($userId);
		} catch (Exception $e) {
			throw('['.$this->classPath.'::delete] - '.  $e->getMessage());
		}
	}

}
