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

/* @namespace Nimbl */
namespace Nimbl;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	Router
 *
 *	Nimbl router class.
 *
 *	@package Nimbl
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Router {

	/**
	 *	@const bool HTTP_ANY Any type of HTTP request.
	 */
	const HTTP_ANY = true;

	/**
	 *	@const string HTTP_GET HTTP GET request.
	 */
	const HTTP_GET = 'GET';

	/**
	 *	@const string HTTP_POST HTTP POST request.
	 */
	const HTTP_POST = 'POST';

	/**
	 *	@const string HTTP_PUT HTTP PUT request.
	 */
	const HTTP_PUT = 'PUT';

	/**
	 *	@const string HTTP_DELETE HTTP DELETE request.
	 */
	const HTTP_DELETE = 'DELETE';

	/**
	 *	@var array $routeMaps Route maps.
	 */
	public static $routeMaps = [];

	/**
	 *	requestMethod
	 *
	 *	Returns request method.
	 *
	 *	@return string
	 */
	public static function requestMethod() {

		return $_SERVER['REQUEST_METHOD'];

	}

	/**
	 *	requestPath
	 *
	 *	Returns current request path.
	 *
	 *	@return string
	 */
	public static function requestPath() {

		$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		$scriptName = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));

		$segments = array_diff_assoc($requestUri, $scriptName);
		$segments = array_filter($segments);

		if(empty($segments) === true) {

			return '/';

		}

		$path = implode('/', $segments);

		$path = parse_url($path, PHP_URL_PATH);

		return $path;

	}

	/**
	 *	requestParameters
	 *
	 *	Returns either full request path as an array, or regex captures if present.
	 *
	 *	@param string $routePattern Route map pattern.
	 *
	 *	@return array
	 */
	public static function requestParameters($routePattern = null) {

		$requestPath = self::requestPath();

		$routePattern = trim($routePattern, '/');

		if(is_null($routePattern) === true) {

			return explode('/', $requestPath);

		}

		if(strpos($routePattern, '(') === false) {

			return explode('/', $routePattern);

		} else {

			$routePattern = '/' . str_replace('/', '\/', $routePattern) . '/i';

			if(preg_match($routePattern, $requestPath, $matches)) {

				array_shift($matches);

				return $matches;

			}

		}

	}

	/**
	 *	route
	 *
	 *	Registers a new route to request method and pattern.
	 *
	 *	@param string $requestMethod HTTP request method.
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function route($requestMethod, $routePattern, Callable $callback, Callable $filter = null) {

		$reflection = new \ReflectionClass(__CLASS__);

		if(in_array($requestMethod, $reflection->getConstants()) === true) {

			if(array_key_exists($routePattern, self::$routeMaps) === true && is_array(self::$routeMaps[$routePattern]) === false) {

				self::$routeMaps[$routePattern] = [];

			}

			$requestParameters = self::requestParameters($routePattern);

			$requestParameters = (is_array($requestParameters)) ? array_filter($requestParameters) : [];

			$requestObject = (object) [
				'filter' => $filter,
				'callback' => $callback,
				'parameters' => $requestParameters
			];

			if($requestMethod === self::HTTP_ANY) {

				self::$routeMaps[$routePattern][self::HTTP_GET] = $requestObject;
				self::$routeMaps[$routePattern][self::HTTP_POST] = $requestObject;
				self::$routeMaps[$routePattern][self::HTTP_PUT] = $requestObject;
				self::$routeMaps[$routePattern][self::HTTP_DELETE] = $requestObject;

			} else {

				self::$routeMaps[$routePattern][$requestMethod] = $requestObject;

			}

		}

	}

	/**
	 *	any
	 *
	 *	Shortcut method for any type of route request. {@see Nimbl\Router::route}
	 *
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function any($routePattern, Callable $callback, Callable $filter = null) {

		return self::route(self::HTTP_ANY, $routePattern, $callback, $filter);

	}

	/**
	 *	get
	 *
	 *	Shortcut method for GET route request. {@see Nimbl\Router::route}
	 *
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function get($routePattern, Callable $callback, Callable $filter = null) {

		return self::route(self::HTTP_GET, $routePattern, $callback, $filter);

	}

	/**
	 *	post
	 *
	 *	Shortcut method for POST route request. {@see Nimbl\Router::route}
	 *
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function post($routePattern, Callable $callback, Callable $filter = null) {

		return self::route(self::HTTP_POST, $routePattern, $callback, $filter);

	}

	/**
	 *	put
	 *
	 *	Shortcut method for PUT route request. {@see Nimbl\Router::route}
	 *
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function put($routePattern, Callable $callback, Callable $filter = null) {

		return self::route(self::HTTP_PUT, $routePattern, $callback, $filter);

	}

	/**
	 *	delete
	 *
	 *	Shortcut method for DELETE route request. {@see Nimbl\Router::route}
	 *
	 *	@param string $routePattern Route map pattern.
	 *	@param callable $callback Route callback.
	 *	@param callable $filter Route filter callback.
	 *
	 *	@return void
	 */
	public static function delete($routePattern, Callable $callback, Callable $filter = null) {

		return self::route(self::HTTP_DELETE, $routePattern, $callback, $filter);

	}

	/**
	 *	dispatch
	 *
	 *	Dispatches router.
	 *
	 *	@return mixed
	 */
	public static function dispatch() {

		$errorRouteObject = self::$routeMaps['404'][self::HTTP_GET];

		foreach(self::$routeMaps as $routePattern => $request) {

			if(array_key_exists(self::requestMethod(), $request) === true) {

				$requestObject = $request[self::requestMethod()];

				if(strpos($routePattern, '(') !== false) {

					$routePattern = trim($routePattern, '/');

				}

				$routeRegex = '/^' . str_replace('/', '\/', $routePattern) . '$/i';

				preg_match($routeRegex, self::requestPath(), $matches);

				if(preg_match($routeRegex, self::requestPath()) !== false && count($matches) > 0) {

					if(is_callable($requestObject->filter) && call_user_func($requestObject->filter) !== true) {

						return call_user_func_array($errorRouteObject->callback, []);

					}

					return call_user_func_array($requestObject->callback, $requestObject->parameters);

				}

			}

		}

		return call_user_func_array($errorRouteObject->callback, []);

	}

}