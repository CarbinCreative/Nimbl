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
 *	render
 *
 *	Renders a *.nim template file.
 *
 *	@param string $template File Template file.
 *	@param array $variables Template variables.
 *
 *	@return string
 */
function render($templateFile, Array $variables = null) {

	$includePath = implode('', [NIMBL_ROOT_PATH, 'app', DIRECTORY_SEPARATOR, 'views', DIRECTORY_SEPARATOR]);

	$parser = new \Nimbl\Template\Parser();

	if(substr($templateFile, -3) === 'nim') {

		$templateData = file_get_contents($includePath . $templateFile);

		$view = new \Nimbl\Template\View($templateData);

		foreach($variables as $variable => $data) {

			$view->$variable = $data;

		}

		return $parser->render($view);

	}

	return null;

}



/**
 *	Load required classes
 */

import('Nimbl\Router');

import('Nimbl\Template\View');
import('Nimbl\Template\Engine');
import('Nimbl\Template\Parser');