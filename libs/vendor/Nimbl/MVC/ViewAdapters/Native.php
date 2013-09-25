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

/* @namespace ViewAdapters */
namespace Nimbl\MVC\ViewAdapters;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Native
 *
 *	Native PHP view adapter.
 *
 *	@package Nimbl
 *	@subpackage MVC
 *	@subpackage ViewAdapters
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Native extends \Nimbl\MVC\ViewAbstract {

	/**
	 *	output
	 *
	 *	Native templates cannot handle raw PHP output.
	 *
	 *	@param string $rawData Unrendered view string.
	 *
	 *	@return string
	 */
	public function output($rawData) {

		return $rawData;

	}

	/**
	 *	render
	 *
	 *	Renders a simple PHP-based view using output buffer.
	 *
	 *	@param string $viewFile Unrendered view file.
	 *
	 *	@return string
	 */
	public function render($viewFile) {

		$includePath = $viewFile;

		if(file_exists($includePath) === true) {

			extract($this->variables);

			ob_start();

			require_once $includePath;

			$output = ob_get_clean();

			return $output;

		}

		return null;

	}

}