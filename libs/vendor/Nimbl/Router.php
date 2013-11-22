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

/* @namespace Nimbl */
namespace Nimbl;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Router
 *
 *	Static routing class.
 *
 *	@package Nimbl
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Router {

	/**
	 *	@var array $routeMaps Registered route maps.
	 */
	public static $routeMaps = [];

	/**
	 *	requestMethods
	 *
	 *	Returns valid request methods.
	 *
	 *	@return string
	 */
	public static function requestMethods() {

		$nimbl = \Nimbl::getInstance();

		$nimbl->httpClient->prepare();

		return $nimbl->httpClient->requestMethods();

	}

	/**
	 *	requestMethod
	 *
	 *	Returns request method.
	 *
	 *	@return string
	 */
	public static function requestMethod() {

		$nimbl = \Nimbl::getInstance();

		return $nimbl->httpClient->getMethod();

	}

	/**
	 *	requestPath
	 *
	 *	Returns current request path, uses {@see uri}.
	 *
	 *	@return string
	 */
	public static function requestPath() {

		return uri();

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

		if($routePattern !== '/') {

			$routePattern = trim($routePattern, '/');

		}

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

		if($routePattern !== '/') {

			$routePattern = trim($routePattern, '/');

		}

		if(in_array($requestMethod, self::requestMethods()) === true || $requestMethod === 'ANY') {

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

			if($requestMethod === 'ANY') {

				foreach(self::requestMethods() as $method) {

					self::$routeMaps[$routePattern][$method] = $requestObject;

				}

			} else {

				self::$routeMaps[$routePattern][$requestMethod] = $requestObject;

			}

		}

	}

	/**
	 *	Static Call
	 *
	 *	Registers route based on HTTP request method.
	 *
	 *	@param string $method Method name.
	 *	@param array $arguments Method arguments.
	 *
	 *	@return void
	 */
	public static function __callStatic($method, $arguments) {

		$method = strtoupper($method);

		if(in_array($method, self::requestMethods()) === true || $method === 'ANY') {

			list($routePattern, $callback, $filter) = $arguments;

			self::route($method, $routePattern, $callback, $filter);

		}

	}

	/**
	 *	dispatch
	 *
	 *	Dispatches router.
	 *
	 *	@return mixed
	 */
	public static function dispatch() {

		$errorRouteObject = self::$routeMaps['error'][self::requestMethod()];

		if(is_object($errorRouteObject) === false) {

			$errorRouteObject = (object) [
				'callback' => function() {

					return '404 Not Found';

				}
			];

		}

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