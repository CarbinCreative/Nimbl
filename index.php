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

/**
 *	@const string NIMBL_ROOT_PATH Nimbl root path.
 */
define('NIMBL_ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Set error reporting and display possible errors
error_reporting(E_ALL);
ini_set('display_erros', 'On');

try {

	// Load Nimbl bootstrap
	require_once implode(DIRECTORY_SEPARATOR, [rtrim(NIMBL_ROOT_PATH, DIRECTORY_SEPARATOR), 'libs', 'vendor', 'Nimbl', 'Bootstrap.php']);

	// Load route definitions
	require_once path('app/routes.php');

	// Dispatch router
	Nimbl\Router::dispatch();

} catch(Exception $exception) {

	echo '<pre style="font:13px monaco, monospace;">';

	print_r($exception);

	echo '</pre>';

}