<?php
/**
* Session Class
*
* This class holds basic general functions to be called
* throughout the application.
*
* @author ivonascimento <ivo@o8o.com.br>
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @author Leandro Menezes
* @author Raphael Pawlik
* @since 2012/11/14
* @version 1.15.1021
* @license SaSeed\license.txt
*/

namespace SaSeed;

Final class Session {

	private static $classPath = 'SaSeed\Session';

	/**
	* Starts a session
	*/
	public static function start() {
		session_start();
	}

	/**
	* Destroys a session
	*/
	public static function destroy() {
		session_destroy();
	}

	/**
	* Sets a variable within a session
	*
	* @param string - variable's name
	* @param string - value
	*/
	public static function setVar($name = false, $value = false) {
		if (($name) && ($value)) {
			$_SESSION[$name] = $value;
		} else {
			throw new \Exception($classPath."::setVar - Not possible to set a variable.");
		}
	}

	/**
	* Retrieves some variable's value from within a session
	*
	* @param string - variable's name
	* @return string - value
	*/
	public static function getVar($name = false) {
		if (($name) && (array_key_exists($name, $_SESSION))) {
			return $_SESSION[$name];
		}
		throw new \Exception($classPath."::getVar - Not a valid session parameter.");
	}

	/**
	* Unset a variable from a session
	*
	* @param string - variable's name
	* @return boolean
	*/
	public function unsetVar($name = false) {
		if (($name) && (array_key_exists($name, $_SESSION))) {
			unset($_SESSION[$name]);
		}
		throw new \Exception($classPath."::unsetVar - Not a valid session parameter.");
	}

	/**
	* Retrieves all session values
	*/
	public static function getAll() {
		return $_SESSION;
	}

	/**
	* Reset session
	*/
	public static function resetAll() {
		$_SESSION = null;
	}

}