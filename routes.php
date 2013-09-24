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

	echo render('app.nim', [
		'title' => 'Nimbl 0.2.1&beta;'
	]);

});

// 404 Not Found route
Nimbl\Router::any('404', function() {

	echo render('app.nim', [
		'title' => '404 Not Found'
	]);

});

// Default route
Nimbl\Router::any('blog', function() {

	echo render('blog.nim', [
		'title' => 'Nimbl Blog',
		'entries' => [
			['title' => 'Hello World', 'body' => 'This is a quick demonstration of Nimbl routing and *.nim template engine.']
		]
	]);

});