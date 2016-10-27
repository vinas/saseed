<?php
/**
* Mapper Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/28
* @version 1.16.1027
* @license SaSeed\license.txt
*/

namespace SaSeed\Handlers;

use SaSeed\Handlers\Exceptions;

class Mapper
{

	/**
	* Populates given object
	*
	* Populates given object with values from array, as long
	* as their attributes' names are the same.
	*
	* @param object
	* @param array
	*/
	public function populate($dest, $src) {
		try {
			if (is_array($src)) {
				return $this->populateFromArray($dest, $src);
			} else if (is_object($src)) {
				return $this->populateFromObject($dest, $src);
			}
			return $src;
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	private function populateFromArray($dest, $src)
	{
		try {
			$attrs = $dest->listProperties();
			foreach ($attrs as $attr) {
				$method = 'set'.ucfirst($attr);
				$dest->$method((isset($src[$attr])) ? $src[$attr] : false);
			}
			return $dest;
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	private function populateFromObject($dest, $src)
	{
		try {
			$destAttrs = $dest->listProperties();
			foreach ($destAttrs as $destAttr) {
				$setMethod = 'set'.ucfirst($destAttr);
				$getMethod = 'get'.ucfirst($destAttr);
				if (method_exists($src, $getMethod)) {
					$dest->$setMethod($src->$getMethod());
				}
			}
			return $dest;
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS, __FUNCTION__, $e);
		}
	}
}
