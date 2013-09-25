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
 *	Config file, you may put what you need in here.
 */

Nimbl\Renderer::registerViewAdapter('Nimbl\MVC\ViewAdapters\Native', 'php');
Nimbl\Renderer::registerViewAdapter('Nimbl\MVC\ViewAdapters\Markdown', 'md');