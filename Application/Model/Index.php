<?php
/************************************************************************************
* Name:				Index Model														*
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

	class Index {
		public function test ($content = false) {
			$content	= '<div>'.$content.'</div>';
			return $content;
		}
	}