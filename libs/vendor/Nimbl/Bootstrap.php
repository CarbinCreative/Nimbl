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
 *	@const string NAMESPACE_SEPARATOR Namespace separator constant.
 */
define('NAMESPACE_SEPARATOR', '\\');



/**
 *	path
 *
 *	Replaces separator in input path string with DIRECTORY_SEPARATOR.
 *
 *	@param string $path Unresolved path string.
 *	@param bool $appendDirectorySeparator Flag specifies whether or not to append DIRECTORY_SEPARATOR.
 *	@param string $separator Path separator.
 *
 *	@return string
 */
function path($path, $appendDirectorySeparator = false, $separator = '/') {

	$path = preg_replace('#' . $separator . '+#', $separator, trim($path, $separator));

	$path = NIMBL_ROOT_PATH . trim(str_replace($separator, DIRECTORY_SEPARATOR, trim($path, $separator)), DIRECTORY_SEPARATOR);

	if($appendDirectorySeparator === true) {

		$path .= DIRECTORY_SEPARATOR;

	}

	return $path;

}

/**
 *	import
 *
 *	Imports a package in libs/vendor.
 *
 *	@param string $package Package import path.
 *
 *	@return bool
 */
function import($package) {

	$packagePath = path("libs/vendor/{$package}", false, NAMESPACE_SEPARATOR) . '.php';

	if(file_exists($packagePath) === true) {

		require_once $packagePath;

		return true;

	}

	return false;

}

// Register custom autoloader
spl_autoload_register(function($className) {

	if(substr(trim($className, NAMESPACE_SEPARATOR), 0, 3) === 'app') {

		$includePath = path('app/controllers/' . trim(substr($className, 3), NAMESPACE_SEPARATOR), false, NAMESPACE_SEPARATOR);

		include_once $includePath . '.php';

		return true;

	} else {

		return import($className);

	}

});

// Import Nimbl functions
import('Nimbl\Functions');

// Import Nimbl base
import('Nimbl\Nimbl');