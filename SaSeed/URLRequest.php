<?php
/************************************************************************************
* Name:				URL Request														*
* File:				SaSeed\URLRequest.php 											*
* Author(s):		Vinas de Andrade e Leandro Menezes								*
*																					*
* Description: 		Contains functions that define which controller and function	*
*					to call.														*
*																					*
* Creation Date:	14/11/2012														*
* Version:			1.15.0326														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	class URLRequest {

		private $params			= false;
		private $paramsPosition	= false;

		/*
		Gets and defines Controller's name
			@return format	- string/boolean
		*/
		public function getController() {
			$params			= $this->getAllURLParams();
			$controller		= (ENV == 'DEV') ? $params[2] : $params[1];
			$controller		= (empty($controller)) ? 'IndexController' :  $controller.'Controller';
			return $controller;
		}

		/*
		Gets and defines Action Function's name
			@return format	- string/boolean
		*/
		public function getActionFunction() {
			$params			= $this->getAllURLParams();
			$pos = (ENV == 'DEV') ? 3 : 2;
			if (!empty($params[$pos])) {
				return $params[$pos];
			}
			return 'index';
		}

		/*
		Gets all requested parameters
			@return format	- array/boolean
		*/
		public function getParams() {
			$params 	= $this->getAllURLParams();
			$totParams	= count($params);
			$start		= (ENV == 'DEV') ? 3 : 2;
			for ($i = $start; $i < $totParams; $i++) {
				$this->paramsPosition[]	= $params[$i];
			}
			return $this->paramsPosition;
		}

		/*
		Gets all parameters sent by post - getPostParams()
			@return format	- array/boolean
		*/
		public function getPostParams() {
			return $_POST;
		}

		/*
		Gets specific parameter - getParam($position)
			@input integer	- value's position
			@return format	- array/boolean
		*/
		public function getParam($position = false) {
			if ($position !== false) {
				$params	= $this->getParams();
				if ($params) {
					return $params[$position];
				}
			}
			return false;
		}

		/*
		Gets specific parameter - getQuery($position)
			@input string	- value's position
			@return format	- string
		*/
		public function getQuery($name = false) {
			if ($name !== false) {
				if (!empty($this->params[$name])) {
					return $this->params[$name];
				}	
			}
			return false;
		}

		/*
		Gets all URL parameters- getAllParams()
			@return format	- string
		*/
		public static function getAllURLParams() {
			$uri	= $_SERVER['REQUEST_URI'];
			$params	= explode('/', $uri);
			return $params;
		}

	}