<?php
/**
* User Repository Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.15.1026
* @license SaSeed\license.txt
*/
namespace Application\Repository;

use SaSeed\Mapper;
use Application\Model\UserModel;

class UserRepository extends \SaSeed\Database\DAO {

	private $db;
	private $table = 'users';
	private $classPath = 'Application\Repository\User';

	public function __construct()
	{
		$this->db = parent::setDatabase('hostinger');
	}

	public function getById($userId = false)
	{
		try {
			$mapper = new Mapper();
			return $mapper->populate(
					new UserModel(),
					$this->db->getRow($this->table, '*', "id = {$userId}")
				);
		} catch (Exception $e) {
			throw('['.$classPath.'::getById] - '.  $e->getMessage());
		}
	}

	public function listAll()
	{
		try {
			$mapper = new Mapper();
			$users = $this->db->getAllRows($this->table);
			for ($i = 0; $i < count($users); $i++) {
				$users[$i] = $mapper->populate(
						new UserModel(),
						$users[$i]
					);
			}
			return $users;
		} catch (Exception $e) {
			throw('['.$this->classPath.'::listAll] - '.  $e->getMessage());
		}
	}


	public function getByEmail($email = false)
	{
		try {
			$mapper = new Mapper();
			return $mapper->populate(
					new UserModel(),
					$this->db->getRow($this->table, '*', "email = '{$email}'")
				);
		} catch (Exception $e) {
			throw('['.$classPath.'::getByEmail] - '.  $e->getMessage());
		}
	}

	public function saveNew($user)
	{
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword()
				)
			);
			$user->setId($this->db->lastId());
			return $user;
		} catch (Exception $e) {
			throw('['.$classPath.'::saveNew] - '.  $e->getMessage());
		}
	}

	public function update($user)
	{
		try {
			if (!$user->getId()) {
				throw new Exception("No User Id");
			}
			$this->db->updateRow(
				$this->table,
				array(
					'user',
					'email',
					'password'
				),
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword()
				),
				"id = ".$user->getId()
			);
			return true;
		} catch (Exception $e) {
			throw('['.$classPath.'::updateUser] - '.  $e->getMessage());
		}
		return false;
	}

	public function deleteUser($user)
	{
		try {
			return $this->deleteUserById($user->getId());
		} catch (Exception $e) {
			throw('['.$classPath.'::deleteUser] - '.  $e->getMessage());
		}
	}

	public function deleteUserById($userId)
	{
		try {
			return $this->db->deleteRow($this->table, " id = " . $userId);
		} catch (Exception $e) {
			throw('['.$classPath.'::deleteUserById] - '.  $e->getMessage());
		}
	}

	public function findUserByLogin($user, $password)
	{
		try {
			return $this->db->getRow($this->table, '*', "user = '{$user}' AND password = '{$password}'");
		} catch (Exception $e) {
			throw('['.$classPath.'::findUserByLogin] - '.  $e->getMessage());
		}
	}

}
