<?php
/**
* View Class
*
* This class holds basic general functions to generate views
*
* @author ivonascimento <ivo@o8o.com.br>
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @author Leandro Menezes
* @author Raphael Pawlik
* @since 2012/11/14
* @version 1.12.1114
* @license SaSeed\license.txt
*/

namespace SaSeed\View;

use SaSeed\View\JavaScriptHandler;
use SaSeed\View\CSSHandler;

Final class View extends FileHandler {

	public static $data	= Array();
	public static $JSHandler;
	public static $CSSHandler;

	/**
	* Renders a template
	*
	* @param string
	*/
	public static function render($name) {
		if ($name) {

			self::$JSHandler = new JavaScriptHandler();	
			self::$CSSHandler = new CSSHandler();	
			ob_start();
			extract(self::$data);
			if (self::templateFileExists($name)) {
				require self::getTemplate($name);
			} else {
				throw New \Exception ("[SaSeed\View\View::render] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFileInformed'] . PHP_EOL);
			}
			ob_end_flush();
		} else {
			throw New \Exception ("[SaSeed\View\View::render] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFile'] . PHP_EOL);
		}
	}

	/**
	* Sets a variable into View context
	*
	* @param string
	* @param string
	*/
	public static function set($name = false, $value = false) {
		if (($name) && ($value)) {
			self::$data[$name] = $value;
		}
	}

	/**
	* Redirects user to root
	*/
	public static function gotoRoot(){
		View::redirect('/', true);
	}

	/**
	* Renders view buffer into a variable
	*
	* @param string - template
	* @param string
	*/
	public static function renderTo($name) {
		try {
			ob_start();
			extract(self::$data);
			if (self::templateFileExists($name)) {
				require self::getTemplate($name);
			} else {
				throw New \Exception ("[SaSeed\View\View::renderTo] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFileInformed'] . PHP_EOL);
			}
			$return	= ob_get_contents();
			ob_end_clean();
			return $return;
		} catch (Exception $e) {
			throw('[SaSeed\View\View::renderTo] - Not possible to render json object' . PHP_EOL);
		}
	}

		/**
	* Append html template to a html
	*
	* @param string - file name
	*/
	public static function appendTemplate($file) {
		echo self::renderTo($file);
	}

	/**
	* Easily redirect user
	*
	* @param string - template/url
	* @param boolean - true for external url, false for internal url
	*/
	public static function redirect($name = false, $full = false) {
		if ($name) {
			if (!$full) {
				$name = parent::setFilePath($name);
				header("Location: {$name}");
			} else {
				header("Location: {$name}");
			}
		}
	}

	/**
	* Prints an array encoded in Json
	*
	* @param array
	*/
	public static function renderJson($array) {
		ob_start();
		extract(self::$data);
		echo json_encode($array);
		ob_end_flush();
	}

	/**
	* Check if template file exists
	*
	* @param string - file name
	*/
	private static function templateFileExists($name) {
		return file_exists(self::getTemplate($name));
	}

	/**
	* Get template
	*
	* @param string - template name
	*/
	private static function getTemplate($name = false) {
		if ($name) {
			$name	= parent::setFilePath($name);
			return TemplatesPath."{$name}.html" ;
		}
		return false;
	}

}