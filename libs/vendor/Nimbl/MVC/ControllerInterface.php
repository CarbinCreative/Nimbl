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
 *	ControllerInterface
 *
 *	Controller interface.
 *
 *	@package Nimbl
 *	@subpackage MVC
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
interface ControllerInterface {

	/**
	 *	index
	 *
	 *	Implemented method should contain logic for default route.
	 *
	 *	@return void
	 */
	public static function index();

	/**
	 *	error
	 *
	 *	Implemented method should contain logic for error route.
	 *
	 *	@return void
	 */
	public static function error();

}