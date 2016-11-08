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

class UserModel implements \JsonSerializable
{

	private $id;
	private $name;
	private $email;

	public function setId($id = false) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setName($name = false) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
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
