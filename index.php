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

/**
 *	@const string NIMBL_ROOT_PATH Nimbl root path.
 */
define('NIMBL_ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

try {

	// Get Nimbl library path
	$libraryPath = implode('', [NIMBL_ROOT_PATH, 'libs', DIRECTORY_SEPARATOR, 'vendor', DIRECTORY_SEPARATOR, 'Nimbl', DIRECTORY_SEPARATOR]);

	// Require bootstrap
	require_once $libraryPath . 'Bootstrap.php';

	// Require routes
	require_once NIMBL_ROOT_PATH . 'routes.php';

	// Dispatch router
	echo Nimbl\Router::dispatch();

} catch(Exception $exception) {

	echo '<pre>';

	var_dump($exception);

	echo '</pre>';

}