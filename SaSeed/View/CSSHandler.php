<?php
/**
* This class handles CSS files
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/21
* @version 1.15.1021
* @license SaSeed\license.txt
*/

namespace SaSeed\View;

Final class CSSHandler extends FileHandler {

	/**
	* Declare CSS files contained in the general css folder
	*/
	public static function declareGeneralCSS() {
		$files = scandir(MainCssPath);
		$totFiles = count($files);
		if ($totFiles > 2) {
			for ($i = 2; $i < $totFiles; $i++) {
				echo self::setCSSTag($files[$i]);
			}
		}
	}

	/**
	* Declare a specific CSS file
	*
	* @param string - file name
	*/
	public static function declareSpecificCSS($file) {
		echo self::setCSSTag($file).'.css';
	}


	private static function setCSSTag($file) {
		return '<link href="'.WebCSSViewPath.parent::setFilePath($file).'" rel="stylesheet"/>'.PHP_EOL;
	}

}