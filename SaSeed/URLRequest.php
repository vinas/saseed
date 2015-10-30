<?php
/**
* URL Request Class
*
* This class contains functions that define which controller
* and action function are to be called.
* It also handles data sent thru GET or POST methods.
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @author Leandro Menezes
* @since 2012/11/14
* @version 1.15.1026
* @license SaSeed\license.txt
*/

namespace SaSeed;

class URLRequest {

	/**
	* Gets Controller's name
	*
	* @return string
	*/
	public function getController() {
		$params = self::getAllURLParams();
		return (empty($params[1])) ? 'IndexController' : $params[1].'Controller';
	}

	/**
	* Gets action Function's name
	*
	* @return string
	*/
	public function getActionFunction() {
		$params = self::getAllURLParams();
		return (!empty($params[2])) ? $params[2] : 'index';
	}

	/**
	* Gets all passed parameters
	*
	* This method checks all SaSeed html data functions
	* and returns the first set of data found, according to the
	* following priority: POST > Friendly URL > GET
	*
	* @return array
	*/
	public function getParams() {
		$params = self::getPostParams();
		if ($params) {
			return $params;
		}
		$params = self::getURLParams();
		if ($params) {
			return $params;
		}
		return self::getGetParams();
	}

	/**
	* Gets all URL parameters
	*
	* @return array
	*/
	public static function getAllURLParams() {
		return explode('/', $_SERVER['REQUEST_URI']);
	}

	/**
	* Gets URL parameters
	*
	* This method gets all values contained in a friendly url
	* excluding controller's and action function's names
	*
	* @return array
	*/
	public static function getURLParams() {
		$urlParams = self::getAllURLParams();
		for ($i = 3; $i < count($urlParams); $i++) {
			$params[] = $urlParams[$i];
		}
		return $params;
	}

	/**
	* Gets all parameters sent by POST method
	*
	* @return array
	*/
	private function getPostParams() {
		return $_POST;
	}

	/**
	* Gets all parameters sent by GET method
	*
	* @return array
	*/
	private function getGetParams() {
		return $_GET;
	}

}