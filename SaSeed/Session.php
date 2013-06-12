<?php
/************************************************************************************
* Name:				Session Functions												*
* File:				Application\FramworkCore\Session.php 							*
* Author(s):		Vinas de Andrade, Raphael Pawlik e Leandro Menezes				*
*																					*
* Description: 		This file declares basic session related functions.				*
*																					*
* Creation Date:	14/11/2012														*
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;
	
	class Session {

		/*
		Starts a session - start()
			@return format	- no return
		*/
		public static function start() {
			session_start();
		}

		/*
		Destroys a session - destroy()
			@return format	- no return
		*/
		public static function destroy() {
			session_destroy();
		}

		/*
		Sets a variable within a session - setVar($name, $value)
			@param string	- variable's name
			@param varchar	- variable's value
			@return format	- boolean
		*/
		public static function setVar($name = false, $value = false) {
			$return					= false;
			if (($name) && ($value)) {
				$_SESSION[$name]	= $value;
				$return				= true;
			}
			return $return;
		}

		/*
		Retrieves some variable's value from within a session - getVar($name)
			@param string	- variable's name
			@return format	- varchar/false
		*/
		public static function getVar($name = false) {
			$return		= false;
			if (($name) && (array_key_exists($name, $_SESSION))) {
				$return	= $_SESSION[$name];
			}
			return $return;
		}

		/*
		Erases a variable from within a session - unsetVar($name)
			@param string	- variable's name
			@return format	- varchar/false
		*/
		public function unsetVar($name = false) {
			$return		= false;
			if (($name) && (array_key_exists($name, $_SESSION))) {
				unset($_SESSION[$name]);
				$return	= true;
			}
			return $return;
		}

		/*
		Saves a mixed object into a session by serializing it - setObject($name, $value)
			@param string	- object's name
			@param mixed	- object
			@return format	- boolean
		*/
		public static function setObject($name = false, $value = false) {
			$return							= false;
			if (($name) && ($value)) {
				$_SESSION['objects'][$name]	= serialize($value);
				$return						= true;
			}
			return $return;
		}

		/*
		Retrieves a mixed saved object from within a session - unsetVar($name)
			@param string	- object's name
			@return format	- object/false
		*/
		public static function getObject($name = false) {
			$return		= false;
			if (($name) && (isset( $_SESSION['objects'][$name]))) {
				$return	= unserialize($_SESSION['objects'][$name]);
			}
			return $return;
		}

	}