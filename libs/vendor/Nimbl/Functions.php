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
 *	url
 *
 *	Returns full URL, excluding fragment and credentials as these are not supported by PHP.
 *
 *	@return string
 */
function url() {

	$ssl = (empty($_SERVER['HTTPS']) === true) ? '' : (strtolower($_SERVER['HTTPS']) === 'on') ? 's' : '';

	$protocol = strtolower($_SERVER['SERVER_PROTOCOL']);
	$protocol = substr($protocol, 0, strpos($protocol, '/')) . $ssl;

	$port = (intval($_SERVER['SERVER_PORT']) === 80) ? '' : (':' . $_SERVER['SERVER_PORT']);

	$url = $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];

	return $url;

}

/**
 *	slug
 *
 *	Returns an URI friendly "slug" from a string.
 *
 *	@param string $string Unresolved string.
 *	@param string $delimiter Slug delimiter.
 *
 *	@return string
 */
function slug($string, Array $replace = null, $delimiter = '-') {

	if(is_array($replace) === true) {

		$string = str_replace($replace, ' ', $string);

	}

	$slug = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	$slug = preg_replace("%[^-/+|\w ]%", '', $slug);
	$slug = strtolower(trim($slug, '-'));
	$slug = preg_replace("/[\/_|+ -]+/", $delimiter, $slug);

	return $slug;

}

/**
 *	uri
 *
 *	Either returns request URI if no argument is provided or returns a valid URI string.
 *
 *	@param string $uri Unresolved URI.
 *
 *	@return string
 */
function uri($uri = null) {

	if(is_null($uri) === true) {

		$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		$scriptName = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));

		$segments = array_diff_assoc($requestUri, $scriptName);
		$segments = array_filter($segments);

		if(empty($segments) === true) {

			return '/';

		}

		$uriPath = implode('/', $segments);

		$uriPath = parse_url($uriPath, PHP_URL_PATH);

		return $uriPath;

	}

	return preg_replace('#/+#', '/', trim(slug($uri), '/'));

}

/**
 *	segment
 *
 *	Returns request URI segment, if it exists.
 *
 *	@param int $index Segment index.
 *
 *	@return string
 */
function segment($index) {

	$segments = explode('/', uri());

	if($index <= 0) {

		$index = 1;

	}

	if($index > 0 && $index <= count($segments)) {

		return $segments[$index];

	}

	return null;

}

/**
 *	render
 *
 *	Shortcut function to invoke view renderers.
 *
 *	@param string $viewFile Unrendered view file.
 *	@param array $variables View variables.
 *
 *	@return string
 */
function render($viewFile, Array $variables = null) {

	return Nimbl\Renderer::render($viewFile, $variables);

}

/**
 *	markdown
 *
 *	Shortcut function to render raw markdown data.
 *
 *	@param string $rawData Unrendered view string.
 *
 *	@return string
 */
function markdown($rawData) {

	return Nimbl\Renderer::output('md', $rawData);

}