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

	/**
	* Sets a parameter within a session
	*
	* @param string - parameter's name
	* @param string - value
	*/
	public  function setParam($param = false, $val = false) {
		if (($param) && ($val)) {
			$_SESSION[$param] = $val;
		} else {
			throw new \Exception('['$classPath."::setParam] - Not possible to set a parameter." . PHP_EOL);
		}
	}

	/**
	* Retrieves some parameter's value from within a session
	*
	* @param string - parameters's name
	* @return string - value
	*/
	public function getParam($param = false) {
		if (($param) && (array_key_exists($name, $_SESSION))) {
			return $_SESSION[$param];
		}
		throw new \Exception('['$classPath."::getParam] - Not a valid session parameter." . PHP_EOL);
	}

	/**
	* Unset a parameter from a session
	*
	* @param string - parameter's name
	* @return boolean
	*/
	public function unsetParam($param = false) {
		if (($param) && (array_key_exists($param, $_SESSION))) {
			unset($_SESSION[$param]);
		}
		throw new \Exception('['$classPath."::unsetParam] - Not a valid session parameter." . PHP_EOL);
	}

}