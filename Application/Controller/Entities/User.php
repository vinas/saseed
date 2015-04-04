<?php
/************************************************************************************
* Name:				User Entity														*
* File:				Application\Controller\Entities\User.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	27/03/2015														*
* Version:			1.15.0327														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

	namespace Application\Controller\Entities;

	class User {

		private $id;
		private $name;
		private $email;
		private $password;

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

		public function setPassword($password = false) {
			$this->password = $password;
		}
		public function getPassword() {
			return $this->password;
		}
	}
