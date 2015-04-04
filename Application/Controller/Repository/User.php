<?php

/************************************************************************************
* Name:				User Repository													*
* File:				Application\Controller\Repository\User.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Service with information.			*
*																					*
* Creation Date:	30/03/2015														*
* Version:			1.15.0330														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Repository;

class User {

	private $db;
	private $table = 'tb_user';
	private $classPath = 'Application\Controller\Repository\User';

	public function __construct() {
		$this->db = $GLOBALS['db'];
	}

	public function getById($userId = false) {
		try {
			return $this->db->getRow($this->table, '*', "id = {$userId}");
		} catch (Exception $e) {
			die('['.$classPath.'::getById] - '.  $e->getMessage());
		}
	}

	public function getByEmail($email = false) {
		try {
			return $this->db->getRow($this->table, '*', "email = '{$email}'");
		} catch (Exception $e) {
			die('['.$classPath.'::getByEmail] - '.  $e->getMessage());
		}
	}

	public function saveNewUser($user) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$user->getName(),
					$user->getEmail(),
					$user->getPassword()
				)
			);
			return $this->db->lastId();
		} catch (Exception $e) {
			die('['.$classPath.'::saveNewUser] - '.  $e->getMessage());
		}
	}

	public function updateUser($user) {
		try {
			if (!$user->getId()) {
				throw new Exception("No User Id");
			}
			$this->db->updateRow(
				$this->table,
				array(
					'name',
					'email',
					'password'
				),
				array(
					$user->getName(),
					$user->getEmail(),
					$user->getPassword()
				),
				"id = ".$user->getId()
			);
			return true;
		} catch (Exception $e) {
			die('['.$classPath.'::updateUser] - '.  $e->getMessage());
		}
		return false;
	}

	public function deleteUser($user) {
		return $this->db->deleteRow($this->table, " id = " . $user->getId());
	}

	public function deleteUserById($userID) {
		return $this->db->deleteRow($this->table, " id = " . $userId);
	}
}
