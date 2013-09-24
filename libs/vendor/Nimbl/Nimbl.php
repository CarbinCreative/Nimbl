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

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Nimbl
 *
 *	Singleton registry base class.
 *
 *	@package Nimbl
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Nimbl {

	/**
	 *	@staticvar object $_instance Instance variable to itself.
	 */
	protected static $__instance;

	/**
	 *	@var array $registry Registry store.
	 */
	protected $registry = [];

	/**
	 *	Constructor
	 *
	 *	Visibility keywird set to private to prevent direct invokation of Nimbl.
	 *
	 *	@return void
	 */
	private function __construct() {}

	/**
	 *	Clone mutator
	 *
	 *	State is set to final and visibility is set to private to disable object cloning.
	 *
	 *	@return void
	 */
	final private function __clone() {}

	/**
	 *	getInstance
	 *
	 *	Returns instance of self, if no instance exists, one is created.
	 *
	 *	@return self
	 */
	public static function getInstance() {

		// No instance exists, create one
		if(is_object(self::$__instance) === false) {

			self::$__instance = new self();

		}

		return self::$__instance;

	}

	/**
	 *	Setter
	 *
	 *	Stores input object in registry.
	 *
	 *	@param string $key Registry parameter name.
	 *	@param mixed $object Registry data.
	 *
	 *	@return void
	 */
	public function __set($key, $object) {

		$this->registry[$key] = $object;

	}

	/**
	 *	Getter
	 *
	 *	Returns registered object.
	 *
	 *	@param string $key Registry parameter name.
	 *
	 *	@return mixed
	 */
	public function __get($key) {

		if(array_key_exists($key, $this->registry) === true) {

			return $this->registry[$key];

		}

		return null;

	}

	/**
	 *	initialize
	 *
	 *	Creates a new instance of input class via ReflectionClass.
	 *
	 *	@param string $className Class name, including namespace.
	 *	@param string $instance Name of class instance name.
	 *	@param array $parameters Optional parameter, should be an array of parameters for {@see $classMethod}.
	 *	@param string $classMethod Optional parameter, name of class method. Defaults to 'newInstance'.
	 *
	 *	@return void
	 */
	public function initialize($className, $instance, $parameters = [], $classMethod = 'newInstance') {

		$this->$instance = call_user_func_array(array(new \ReflectionClass($className), $classMethod), $parameters);

	}

}