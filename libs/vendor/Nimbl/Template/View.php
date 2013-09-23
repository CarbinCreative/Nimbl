<?php
/**
 *	Nimbl
 *
 *	Nimbl is a micro framework written in PHP 5.4.
 *
 *	@author Robin Grass <http://uiux.se/>
 *
 *	@link https://github.com/CarbinCreative/nimbl
 *
 *	@license http://opensource.org/licenses/MIT MIT
 */

/* @namespace Template */
namespace Nimbl\Template;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	View
 *
 *	View object.
 *
 *	@package Nimbl
 *	@subpackage Template
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class View {

	/**
	 *	@var array $variables View variable store.
	 */
	protected $variables = [];

	/**
	 *	@var string $template View template data.
	 */
	protected $template;

	public function __construct($template) {

		$this->template = $template;

	}

	/**
	 *	Setter
	 *
	 *	Registers view variable.
	 *
	 *	@param string $variable Variable name.
	 *	@param int|float|string $data Variable data.
	 *
	 *	@return void
	 */
	public function __set($variable, $data) {

		$this->variables[$variable] = $data;

	}

	/**
	 *	Getter
	 *
	 *	Returns registered view variable.
	 *
	 *	@param string $variable Variable name.
	 *
	 *	@return mixed
	 */
	public function __get($variable) {

		return $this->get($variable);

	}

	/**
	 *	get
	 *
	 *	Returns registered view variable.
	 *
	 *	@param string $variable Variable name.
	 *
	 *	@return mixed
	 */
	public function get($variable) {

		if(array_key_exists($variable, $this->variables) === true) {

			return $this->variables[$variable];

		}

		return null;

	}

	/**
	 *	template
	 *
	 *	Returns view template data.
	 *
	 *	@return string
	 */
	public function template() {

		return $this->template;

	}

}