<?php
/**
* This class handles JavaScript files
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/21
* @version 1.15.1021
* @license SaSeed\license.txt
*/

namespace SaSeed\View;

Final class JavaScriptHandler extends FileHandler {

	/**
	* Declare JS files contained in the lib folder
	*/
	public static function declareGeneralJSLibs() {
		self::declareJSFilesFromFolder('libs');
	}

	/**
	* Declare JS files contained in the general folder
	*/
	public static function declareGeneralJS() {
		self::declareJSFilesFromFolder('General');
	}

	/**
	* Declare an specific JS
	*
	* @param string - file name
	*/
	public static function declareSpecificJS($file) {
		echo self::setJSTag(parent::setFilePath($file).'.js');
	}

	/**
	* Loads general JS library files' content into the template
	*/
	public static function loadGeneralJSLibs() {
		parent::renderFilesFromFolder(MainJsPath.'Libs'.DIRECTORY_SEPARATOR, 'js');
	}

	/**
	* Loads general JS files' content into the template
	*/
	public static function loadGeneralJS() {
		parent::renderFilesFromFolder(MainJsPath.'General'.DIRECTORY_SEPARATOR, 'js');
	}

	/**
	* Declare all JS files contained in given Js folder
	*
	* @param string - folder's name
	*/
	private static function declareJSFilesFromFolder($folder) {
		$files = scandir(MainJsPath.$folder.DIRECTORY_SEPARATOR);
		$totFiles = count($files);
		if ($totFiles > 2) {
			for ($i = 2; $i < $totFiles; $i++) {
				echo self::setJSTag($folder.'/'.$files[$i]);
			}
		}
	}

	private static function setJSTag($fileName) {
		return '<script type="text/javascript" src="'.WebJSViewPath.parent::setFilePath($fileName).'"></script>'.PHP_EOL;
	}

}