<?php
/**
* Response User Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1026
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class UserResponseModel implements \JsonSerializable
{

	private $code;
	private $message;
	private $id;
	private $user;
	private $email;

	public function setCode($code)
	{
		$this->code = $code;
	}
	public function getCode()
	{
		return $this->code;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}
	public function getMessage()
	{
		return $this->message;
	}

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
