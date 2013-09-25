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
 *	Define your routes below, keep or overwrite the / and /404 error routes.
 */

// Default route
Nimbl\Router::any('/', 'app\SampleController::index');

// Error route
Nimbl\Router::any('/404', 'app\SampleController::error');

// Sample view examples
Nimbl\Router::any('/samples/native', 'app\SampleController::native');
Nimbl\Router::any('/samples/markdown', 'app\SampleController::markdown');