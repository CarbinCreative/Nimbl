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

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	@const string NAMESPACE_SEPARATOR Namespace separator constant.
 */
define('NAMESPACE_SEPARATOR', '\\');



/**
 * 	import
 *
 *	Imports any Nimbl-specific class.
 *
 *	@param string $namespacePath Namespace include path.
 *
 *	@return void
 */
function import($namespacePath) {

	$namespacePath = trim($namespacePath, NAMESPACE_SEPARATOR);

	$importPath = implode('', [NIMBL_ROOT_PATH, 'libs', DIRECTORY_SEPARATOR, 'vendor', DIRECTORY_SEPARATOR]);

	$importPath .= str_ireplace(NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, trim($namespacePath, NAMESPACE_SEPARATOR)) . '.php';

	require_once $importPath;

}



/**
 *	Load required classes
 */

import('Nimbl\Functions');

import('Nimbl\Router');

import('Nimbl\Template\View');
import('Nimbl\Template\Engine');
import('Nimbl\Template\Parser');