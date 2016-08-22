<?php
/**
* User Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.15.1026
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class UserModel
{

	private $id;
	private $user;
	private $email;
	private $password;

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

	public function setPassword($password = false) {
		$this->password = $password;
	}
	public function getPassword() {
		return $this->password;
	}

	public function setActive($active = false) {
		$this->active = $active;
	}
	public function getActive() {
		return $this->active;
	}

	public function listProperties() {
		return array_keys(get_object_vars($this));
	}

}
