<?php
/**
* DAO Class
*
* Someone willl eventually write a description here.
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/09/02
* @version 1.15.0902
* @license SaSeed\license.txt
*/

namespace SaSeed\Database;

use SaSeed\Database\Database;
use SaSeed\Database\Pagination;

class DAO {

	/**
	* Set and connect to Database
	*
	* It loads database connection information from file Config\Database.ini
	*
	* @param string - database name
	*/
	public function setDatabase($dbName) {
		$settings = parse_ini_file(ConfigPath.'database.ini', true);
		$db	= new Database();
		$db->DBConnection(
			$settings[$dbName]['driver'],
			$settings[$dbName]['host'],
			$settings[$dbName]['dbname'],
			$settings[$dbName]['user'],
			$settings[$dbName]['password']
		);
		return $db;
	}

}
