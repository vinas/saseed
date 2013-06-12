<?php
/************************************************************************************
* Name:				User Model														*
* File:				Application\Model\Index.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Index's model.										*
*																					*
* Creation Date:	15/11/2012														*
* Version:			1.12.1115														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace Application\Model;

	class User {
		public function userList ($users = false) {
			$return		= false;
			if ($users) {
				echo '<pre>';
				print_r($users);
				die;
			}
			return $return;
		}
	}