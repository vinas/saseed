<?php
/**
* This class handles files
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/21
* @version 2.15.1031
* @license SaSeed\license.txt
*/

namespace SaSeed\Output;

class Files
{

	/**
	* Get all files' names in a folder given folder. The second
	* parameter will serve as a filter for file extensions.
	*
	* @param string
	* @param string
	* @return array
	*/
	public static function getFilesFromFolder($folder, $ext = false)
	{
		$files = scandir($folder);
		if (count($files) > 2) {
			if ($ext) {
				$res = [];
				for ($i = 0; $i < count($files); $i++) {
					$pathInfo = pathinfo($folder.$files[$i]);
					if ($pathInfo['extension'] == $ext)
						$res[] = $files[$i];
				}
				return $res;
			}
			unset($files[0]);
			unset($files[1]);
			return array_slice($files, 2);
		}
		return false;
	}

	/**
	* format file's path
	*
	* @param string - file name and path
	*/
	public static function setFilePath($file)
	{
		return str_replace('_','/', $file);
	}

	/**
	* Compress given file content
	*
	* @param string - content
	* @param string - compressed content
	*/
	private static function compress($buffer)
	{
		// remove comments
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		// remove tabs, spaces, newlines, etc.
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  '), '', $buffer);
		// remove unnecessary spaces.
		$buffer = str_replace('{ ', '{', $buffer);
		$buffer = str_replace(' }', '}', $buffer);
		$buffer = str_replace('; ', ';', $buffer);
		$buffer = str_replace(', ', ',', $buffer);
		$buffer = str_replace(' {', '{', $buffer);
		$buffer = str_replace('} ', '}', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(' ,', ',', $buffer);
		$buffer = str_replace(' ;', ';', $buffer);
		return $buffer;
	}

}