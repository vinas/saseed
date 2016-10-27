<?php
/**
* This class handles files
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/21
* @version 1.15.1021
* @license SaSeed\license.txt
*/

namespace SaSeed\Output;

class FileHandler
{

	/**
	* Render all files' contents from given folder
	*
	* @param string - folder name
	* @param string - file type name
	*/
	public static function renderFilesFromFolder($folder, $type)
	{
		$files = scandir($folder);
		$totFiles = count($files);
		if ($totFiles > 2) {
			switch ($type) {
				case 'js':
					echo '<script>'.PHP_EOL;
					break;
				case 'css':
					echo '<style>'.PHP_EOL;
					break;
			}
			for ($i = 2; $i < $totFiles; $i++) {
				require_once($folder.DIRECTORY_SEPARATOR.$files[$i]);
			}
			switch ($type) {
				case 'js':
					echo '</script>'.PHP_EOL;
					break;
				case 'css':
					echo '</style>'.PHP_EOL;
					break;
			}
		}
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