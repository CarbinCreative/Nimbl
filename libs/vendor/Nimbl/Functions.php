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
 *	redirect
 *
 *	Redirects, either by a simple refresh or by changing the location header.
 *
 *	@param string $uri URI to redirect to.
 *	@param string $method Redirect method to use, 'location', 'refresh' or 'javascript'.
 *	@param array $params Array containing additional parameters to send.
 *
 *	@return void
 */
function redirect($uri, $method = null, $params = null) {

	$method = (is_null($method) === true) ? 'location' : $method;
	$params = (is_null($params) === true) ? [] : $params;

	switch($method) {

		case 'refresh' :

			$delay = (array_key_exists('delay', $params) && isset($params['delay'])) ? $params['delay'] : 0;

			@session_write_close();

			header("Refresh: {$delay}; URL={$uri}");
			exit;

		break;
		case 'location' :

			$statusCode = (array_key_exists('httpStatusCode', $params) && isset($params['httpStatusCode'])) ? $params['httpStatusCode'] : 302;

			@session_write_close();

			header("Location: {$uri}", true, $statusCode);
			exit;

		break;
		case 'javascript' :

			$delay = $delay = (array_key_exists('delay', $params) && isset($params['delay'])) ? intval($params['delay']) * 1000 : 0;

			echo '<script type="text/javascript">setTimeout(function() { window.location = \'' . $uri . '\'; }, ' . $delay . ');</script>';

		break;

	}

}

/**
 *	slug
 *
 *	Creates URL friendly slug from a string.
 *
 *	@param string $string String to convert to slug.
 *
 *	@return string
 */
function slug($string) {

	return strtolower(
		trim(
			preg_replace(
				'~[^0-9a-z]+~i',
				'-',
				preg_replace(
					'~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i',
					'$1',
					htmlentities($string, ENT_QUOTES, 'UTF-8')
				)
			),
		'-')
	);

}