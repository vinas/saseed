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
* @version 1.16.1026
* @license SaSeed\license.txt
*/

namespace SaSeed\Output;

use SaSeed\Handlers\Exceptions;
use SaSeed\Output\JavaScriptHandler;
use SaSeed\Output\CSSHandler;

Final class View extends FileHandler
{

	public static $data	= Array();
	public static $JSHandler;
	public static $CSSHandler;

	/**
	* Renders a template
	*
	* @param string
	*/
	public static function render($name)
	{
		if ($name) {
			self::$JSHandler = new JavaScriptHandler();
			self::$CSSHandler = new CSSHandler();
			if (self::templateFileExists($name)) {
				ob_start();
				extract(self::$data);
				require self::getTemplate($name);
				ob_end_flush();
			} else {
				Exceptions::throwNew(
					__CLASS__,
					__FUNCTION__,
					'Template file not found.'
				);
			}
		} else {
			Exceptions::throwNew(
				__CLASS__,
				__FUNCTION__,
				'Template file not informed.'
			);
		}
	}

	/**
	* Sets a variable into View context
	*
	* @param string
	* @param string
	*/
	public static function set($name, $value = false)
	{
		if ($name) {
			self::$data[$name] = $value;
		}
	}

	/**
	* Redirects user to root
	*/
	public static function gotoRoot()
	{
		View::redirect('/', true);
	}

	/**
	* Renders view buffer into a variable
	*
	* @param string - template
	* @param string
	*/
	public static function renderTo($name)
	{
		try {
			ob_start();
			extract(self::$data);
			if (self::templateFileExists($name)) {
				require self::getTemplate($name);
			} else {
				Exceptions::throwNew(
					__CLASS__,
					__FUNCTION__,
					'Template file not found'
				);
			}
			$return	= ob_get_contents();
			ob_end_clean();
			return $return;
		} catch (Exception $e) {
			Exceptions::throwNew(
				__CLASS__,
				__FUNCTION__,
				'Not possible to render: '.$e->getMessage()
			);
		}
	}

	/**
	* Append html template to a html
	*
	* @param string - file name
	*/
	public static function appendTemplate($file)
	{
		echo self::renderTo($file);
	}

	/**
	* Easily redirect user
	*
	* @param string - template/url
	* @param boolean - true for external url, false for internal url
	*/
	public static function redirect($name = false, $full = false)
	{
		if ($name) {
			if (!$full) {
				$name = parent::setFilePath($name);
			}
			header("Location: {$name}");
		}
	}

	/**
	* Prints an array encoded in Json
	*
	* @param array
	*/
	public static function renderJson($array) 
	{
		try {
			ob_start();
			extract(self::$data);
			echo json_encode($array);
			ob_end_flush();
		} catch (Exception $e) {
			Exceptions::throwNew(
				__CLASS__,
				__FUNCTION__,
				'Not possible to render json: '.$e->getMessage()
			);
		}
	}

	/**
	* Check if template file exists
	*
	* @param string - file name
	*/
	private static function templateFileExists($name)
	{
		if (file_exists(self::getTemplate($name))) {
			return true;
		}
		return false;
	}

	/**
	* Get template
	*
	* @param string - template name
	*/
	private static function getTemplate($name = false)
	{
		if ($name) {
			$name	= parent::setFilePath($name);
			return TemplatesPath."{$name}.html" ;
		}
		return false;
	}

}