<?php
/************************************************************************************
* Name:				User Repository													*
* File:				Application\Controller\User.php 								*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This file is an example. It contains pre-written functions that	*
*					execute Database tasks regarding user related information.		*
*																					*
* Creation Date:	27/11/2012														*
* Version:			1.12.1127														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace Application\Controller\Repository;

	class User {
		
		/*
		Get User by Id - getById($id)
			@param integer	- User Id
			@return format	- Mixed array
		*/
		public function getById($id = false) {
			// Database Connection
			$db					= $GLOBALS['db'];
			// Initialize variables
			$return				= false;
			// if email was sent
			if ($id) {
				// Query set up
				$table			= 'tb_user';
				$select_what	= '*';
				$conditions		= "id = '{$id}'";
				$return			= $db->getRow($table, $conditions, $select_what);
			}
			// Return
			return $return;
		}

		/*
		Get User by Email - getByEmail($email)
			@param string	- User email
			@return format	- Mixed array
		*/
		public function getByEmail($email = false) {
			// Database Connection
			$db					= $GLOBALS['db'];
			// Initialize variables
			$return				= false;
			// if email was sent
			if ($email) {
				// Query set up
				$table			= 'tb_user';
				$select_what	= '*';
				$conditions		= "vc_email = '{$email}'";
				$return			= $db->getRow($table, $conditions, $select_what);
			}
			// Return
			return $return;
		}

		/*
		Get User by Name - getByName($name)
			@param string	- User name
			@return format	- Mixed array
		*/
		public function getByName($name = false) {
		}

		/*
		Get All Users - getAll($max)
			@param integer	- Max rows
			@return format	- Mixed array
		*/
		public function getAll($max = 13) {
			// Database Connection
			$db				= $GLOBALS['db'];
			// Initialize variables
			$return			= false;
			// Query set up
			$table			= 'tb_user';
			$select_what	= '*';
			$conditions		= "1";
			$return			= $db->getAllRows_Arr($table, 0, $max, $select_what, $conditions);
			// Return
			return $return;
		}

		/*
		Get Searched Users - getSearched($vc_search, $mas)
			@param string	- String to be searched
			@param integer	- Max rows
			@return format	- Mixed array
		*/
		public function getSearched($vc_search = false, $max = 13) {
			// Database Connection
			$db					= $GLOBALS['db'];
			// Initialize variables
			$return				= false;
			// If something was sent
			if ($vc_search) {
				// Query set up
				$table			= 'tb_user';
				$select_what	= '*';
				$conditions		= "id <> 1 AND (vc_name LIKE '%{$vc_search}%' OR vc_user LIKE '%{$vc_search}%' OR vc_email LIKE '%{$vc_search}%')";
				$return			= $db->getAllRows_Arr($table, 0, $max, $select_what, $conditions);
			}
			// Return
			return $return;
		}

		/*
		Check username - checkUser($user)
			@param string	- user name
			@return bool
		*/
		public function checkUser($user = false) {
			// Database Connection
			$db					= $GLOBALS['db'];
			// Initialize variables
			$return				= false;
			$user				= false;
			// if username was sent
			if ($user) {
				// Query set up
				$table			= 'tb_user';
				$select_what	= 'id';
				$conditions		= "id <> 1 AND vc_user = '{$user}'";
				$user			= $db->getRow($table, $conditions, $select_what);
				if ($user) {
					$return		= true;
				}
			}
			// Return
			return $return;
		}

		/*
		Check email - checkEmail($email)
			@param string	- user email
			@return bool
		*/
		public function checkEmail($email = false) {
			// Database Connection
			$db				= $GLOBALS['db'];
			// Initialize variables
			$return			= false;
			$user			= false;
			// if email was sent
			if ($email) {
				// Query set up
				$table			= 'tb_user';
				$select_what	= 'id';
				$conditions		= "id <> 1 AND vc_email = '{$email}'";
				$user			= $db->getRow($table, $conditions, $select_what);
				if ($user) {
					$return		= true;
				}
			}
			// Return
			return $return;
		}

		/*
		Insert user into Database - insert($user_data)
			@param array	- Mixed with user info (order like database w/ no id)
			@return boolean
		*/
		public function insert($user_data = false) {
			// Initialize variables
			$return						= false;
			// Database Connection
			$db							= $GLOBALS['db'];
			// Validate sent information
			if ($user_data) {
				$name					= (isset($user_data[0])) ? $user_data[0] : false;
				$email					= (isset($user_data[1])) ? $user_data[1] : false;
				$user					= (isset($user_data[2])) ? $user_data[2] : false;
				$password				= (isset($user_data[3])) ? $user_data[3] : false;
				if (($name) && ($email) && ($user) && ($password)) {
					// Check if user or email is already taken
					$table				= 'tb_user';
					$conditions			= "vc_name = '{$name}' OR vc_email = '{$email}'";
					$select_what		= 'id';
					$return				= $db->getRow($table, $conditions, $select_what);
					// If user or email is taken
					if ($return) {
						$return			= 'taken';
					// If username and email are free to use
					} else {
						// Prepare values
						$values[]		= $name;
						$values[]		= $email;
						$values[]		= $user;
						$values[]		= $password;
						// Add User to Database
						$return			= $db->insertRow('tb_user', $values, '');
					}
				}
			}
			return $return;
		}

		/*
		Update user info - update($user_data)
			@param array	- Mixed with user info (order like database w/ id)
			@return boolean
		*/
		public function update($user_data = false) {
			// Initialize variables
			$return						= false;
			// Database Connection
			$db							= $GLOBALS['db'];
			// Validate sent information
			if ($user_data) {
				$id						= (isset($user_data[0])) ? $user_data[0] : false;
				$name					= (isset($user_data[1])) ? $user_data[1] : false;
				$email					= (isset($user_data[2])) ? $user_data[2] : false;
				$user					= (isset($user_data[3])) ? $user_data[3] : false;
				if (($id) && ($name) && ($email) && ($user)) {
					$table				= 'tb_user';
					$fields[]			= 'id';
					$fields[]			= 'vc_name';
					$fields[]			= 'vc_email';
					$fields[]			= 'vc_user';
					$conditions			= "id = {$id}";
					$return				= $db->updateRow($table, $fields, $user_data, $conditions);
					// If user or email is taken
					if ($return) {
						$return			= 'taken';
					// If username and email are free to use
					} else {
						// Prepare values
						$values[]		= $name;
						$values[]		= $email;
						$values[]		= $user;
						$values[]		= $password;
						// Add User to Database
						$return			= $db->insertRow('tb_user', $values, '');
					}
				}
			}
			return $return;
		}

		/*
		Delete user - delete($id)
			@param array	- Mixed with user info (order like database w/ id)
			@return boolean
		*/
		public function delete($id = false) {
			// Initialize variables
			$return			= false;
			// Database Connection
			$db				= $GLOBALS['db'];
			// If user ID was sent
			if ($id) {
				// Set up query
				$table		= 'tb_user';
				$conditions	= 'id = '.$id;
				$return		= $db->deleteRow($table, $conditions);
			}
			return $return;
		}

	}