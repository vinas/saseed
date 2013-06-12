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
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	class URLRequest {

		private $params				= false;
		private $params_position	= false;

		/*
		Gets and defines Controller's name - getController()
			@return format	- string/boolean
		*/
		public function getController() {
			$controller		= false;
			$params			= $this->getAllURLParams();
			if (ENV == 'DEV') {
				$controller	= $params[2];
			} else {
				$controller	= $params[1];
			}
			if (empty($controller)) {
				$controller	= 'IndexController';
			} else {
				$controller	= $controller.'Controller';
			}
			return $controller;
		}

		/*
		Gets and defines Action Function's name - getActionFunction()
			@return format	- string/boolean
		*/
		public function getActionFunction() {
			$function		= false;
			$params			= $this->getAllURLParams();
			if (ENV == 'DEV') {
				$pos		= 3;
			} else {
				$pos		= 2;
			}
			if (!empty($params[$pos])) {
				$function	= $params[$pos];
			}else{
				$function 	= 'index';
			}
			return $function;
		}

		/*
		Gets all requested parameters- getParams()
			@return format	- array/boolean
		*/
		public function getParams() {
			$sent_params		= false;
			$params				= $this->getAllURLParams();
			$tot_params			= count($params);
			if (ENV == 'DEV') {
				$start			= 3;
			} else {
				$start			= 2;
			}
			for ($i = $start; $i < $tot_params; $i++) {
				/*
				if (($start - $i) % 2 == 0) {
					$this->params[$params[$i]]	= $params[$i+1];
				}
				*/
				$this->params_position[]	= $params[$i];
			}
			return $this->params_position;
		}



		/*
		Gets specific parameter - getParam($position)
			@input integer	- value's position
			@return format	- array/boolean
		*/
		public function getParam($position = false) {
			$parameter			= false;
			if ($position !== false) {
				$params			= $this->getParams();
				if ($params) {
					$parameter	= $params[$position];
				}
			}
			return $parameter;
		}

		/*
		Gets specific parameter - getQuery($position)
			@input string	- value's position
			@return format	- string
		*/
		public function getQuery($name = false) {
			$parameter			= false;
			if ($name !== false) {
				if (!empty($this->params[$name])) {
					$parameter	= $this->params[$name];
				}	
			}
			return $parameter;
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