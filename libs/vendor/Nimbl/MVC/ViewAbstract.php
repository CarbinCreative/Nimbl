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

/* @namespace MVC */
namespace Nimbl\MVC;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	ViewAbstract
 *
 *	Output independent abstract.
 *
 *	@package Nimbl
 *	@subpackage MVC
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
abstract class ViewAbstract {

	/**
	 *	@var array $variables View variable store.
	 */
	protected $variables = [];

	/**
	 *	Setter
	 *
	 *	Stores view variable.
	 *
	 *	@param string $key Variable name.
	 *	@param mixed $object Variable data.
	 *
	 *	@return void
	 */
	public function __set($key, $object) {

		$this->variables[$key] = $object;

	}

	/**
	 *	Getter
	 *
	 *	Returns view variable.
	 *
	 *	@param string $key Variable name.
	 *
	 *	@return mixed
	 */
	public function __get($key) {

		if(array_key_exists($key, $this->variables) === true) {

			return $this->variables[$key];

		}

		return null;

	}

	/**
	 *	setVariables
	 *
	 *	Sets many variables to view variable store.
	 *
	 *	@param array $variables View variables.
	 *
	 *	@return void
	 */
	public function setVariables(Array $variables) {

		foreach($variables as $key => $variable) {

			$this->$key = $variable;

		}

	}

	/**
	 *	getVariables
	 *
	 *	Returns variable store.
	 *
	 *	@return array
	 */
	public function getVariables() {

		return $this->variables;

	}

	/**
	 *	output
	 *
	 *	Implemented method must return rendered view as a string.
	 *
	 *	@param string $rawData Unrendered view string.
	 *
	 *	@return string
	 */
	abstract public function output($rawData);

	/**
	 *	render
	 *
	 *	Implemented method must return rendered view as a string.
	 *
	 *	@param string $viewFile Unrendered view file.
	 *
	 *	@return string
	 */
	abstract public function render($viewFile);

}