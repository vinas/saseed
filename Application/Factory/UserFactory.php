<?php
/**
* User Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.2027
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\UserModel;

class UserFactory extends \SaSeed\Database\DAO {

	private $db;
	private $queryBuilder;
	private $table = 'users';

	public function __construct()
	{
		$this->db = parent::setDatabase('hostinger');
		$this->queryBuilder = parent::setQueryBuilder();
	}

	public function getById($userId = false)
	{
		$user = new UserModel();
		try {
			$mapper = new Mapper();
			$this->queryBuilder->from($this->table);
			$this->queryBuilder->where([
					'id',
					'=',
					$userId,
					$this->queryBuilder->getMainTableAlias()
				]);
			$user = $mapper->populate(
					$user,
					$this->db->getRow($this->queryBuilder->getQuery())
				);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $user;
		}
	}

	public function listAll()
	{
		$users = [];
		try {
			$mapper = new Mapper();
			$this->queryBuilder->from($this->table);
			$this->queryBuilder->select(['id', 'user', 'email']);
			$users = $this->db->getRows($this->queryBuilder->getQuery());
			for ($i = 0; $i < count($users); $i++) {
				$users[$i] = $mapper->populate(
						new UserModel(),
						$users[$i]
					);
			}
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $users;
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
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $user;
		}
	}

	public function update($user)
	{
		$res = false;
		try {
			if (!$user->getId()) {
				Exceptions::throwNew(
					__CLASS__,
					__FUNCTION__,
					'No user Id informed.'
				);
				return false;
			}
			$this->db->update(
				$this->table,
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword()
				),
				array(
					'user',
					'email',
					'password'
				),
				"id = ".$user->getId()
			);
			$res = true;
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
			$res = false;
		} finally {
			return $res;
		}
	}

	public function deleteUser($user)
	{
		try {
			$this->deleteUserById($user->getId());
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function deleteUserById($userId)
	{
		try {
			$this->db->deleteRow($this->table, ['id', '=', $userId]);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}
}
