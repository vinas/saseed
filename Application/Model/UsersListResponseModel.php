<?php
/**
* Response User Model for List
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1026
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class UsersListResponseModel implements \JsonSerializable
{

	private $id;
	private $user;
	private $email;

	public function setId($id = false) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setUser($user = false) {
		$this->user = $user;
	}
	public function getUser() {
		return $this->user;
	}

	public function setEmail($email = false) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}

	public function listProperties() {
		return array_keys(get_object_vars($this));
	}

	public function JsonSerialize()
	{
		return get_object_vars($this);
	}
}
