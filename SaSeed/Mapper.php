<?php
/**
* Mapper Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/28
* @version 1.15.1028
* @license SaSeed\license.txt
*/
namespace SaSeed;

class Mapper {

	/**
	* Populates given object
	*
	* Populates given object with values from array, as long
	* as their attributes' names are the same.
	*
	* @param object
	* @param array
	*/
	public function populate($obj, $array) {
		try {
			if (method_exists($obj, 'listProperties')) {
				$attrs = $obj->listProperties();
				foreach ($attrs as $attr) {
					$method = 'set'.ucfirst($attr);
					$obj->$method((isset($array[$attr])) ? $array[$attr] : false);
				}
				return $obj;
			}
			throw new \Exception('[SaSeed\Mapper::populate] - "listProperties" method not declared on model.');
		} catch (Exception $e) {
			throw('[SaSeed\Mapper::populate] - '.  $e->getMessage());
		}
	}

}
