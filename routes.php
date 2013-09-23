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



// Default route
Nimbl\Router::any('/', function() {

	return 'Nimbl 0.1&beta;';

});

// 404 Not Found route
Nimbl\Router::any('404', function() {

	return '404 Not Found';

});

// Test POST to base request
Nimbl\Router::post('/', function() {

	return "Postin' some dataz!";

});