<?php
/**
 *	Nimbl
 *
 *	Nimbl is a micro framework written in PHP 5.4.
 *
 *	@author Robin Grass <http://uiux.se/>
 *
 *	@link https://github.com/CarbinCreative/Nimbl
 *
 *	@license http://opensource.org/licenses/MIT MIT
 */

/* @namespace Nimbl */
namespace Nimbl;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Renderer
 *
 *	Static view rendering handler.
 *
 *	@package Nimbl
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Renderer {

	protected static $viewAdapters = [];

	/**
	 *	registerView
	 *
	 *	Registers view adapter using view file extension as key.
	 *
	 *	@param string $viewAdapter View adapter name.
	 *	@param string $viewFileExtension View file extension.
	 *
	 *	@return void
	 */
	public static function registerViewAdapter($viewAdapter, $viewFileExtension) {

		self::$viewAdapters[$viewFileExtension] = $viewAdapter;

	}

	/**
	 *	render
	 *
	 *	Renders view file if view adapter exists, based on view file extension.
	 *
	 *	@param string $viewFile Unrendered view file.
	 *	@param array $variables View variables.
	 *
	 *	@return string|bool
	 */
	public static function render($viewFile, Array $variables = null) {

		$viewFileExtension = pathinfo($viewFile, PATHINFO_EXTENSION);

		if(array_key_exists($viewFileExtension, self::$viewAdapters) === true) {

			$viewAdapter =  call_user_func_array(array(new \ReflectionClass(self::$viewAdapters[$viewFileExtension]), 'newInstance'), []);

			if(is_null($variables) === false) {

				$viewAdapter->setVariables($variables);

			}

			$viewFilePath = path("app/views/{$viewFile}");

			return $viewAdapter->render($viewFilePath);

		}

		return false;

	}

	/**
	 *	output
	 *
	 *	Renders and outputs raw string data.
	 *
	 *	@param string $rawData Unrendered view string.
	 *
	 *	@return string
	 */
	public static function output($adapterId, $rawData) {

		if(array_key_exists($adapterId, self::$viewAdapters) === true) {

			$viewAdapter =  call_user_func_array(array(new \ReflectionClass(self::$viewAdapters[$adapterId]), 'newInstance'), []);

			return $viewAdapter->output($rawData);

		}

		return false;

	}

}