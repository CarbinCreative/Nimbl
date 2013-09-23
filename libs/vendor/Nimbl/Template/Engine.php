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

/* @namespace Template */
namespace Nimbl\Template;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	Engine
 *
 *	Template parser engine.
 *
 *	@package Nimbl
 *	@subpackage Template
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Engine {

	/**
	 *	@const string OPENING_DELIMITER Template tag opening delimiter.
	 */
	const OPENING_DELIMITER = '{{';

	/**
	 *	@const string CLOSING_DELIMITER Template tag closing delimiter.
	 */
	const CLOSING_DELIMITER = '}}';

	/**
	 *	@var array $nodes Template node patterns.
	 */
	private $nodes = [];

	/**
	 *	@var \Nimbl\Template\View $view Template view object.
	 */
	private $view;

	/**
	 *	registerNode
	 *
	 *	Registers node pattern and callback.
	 *
	 *	@param string $nodeName Node name.
	 *	@param string $pattern Node regular expression.
	 *	@param callable $callback Node match callback handler.
	 *
	 *	@return void
	 */
	public function registerNode($nodeName, $pattern, Callable $callback) {

		$this->nodes[$nodeName] = (object) [
			'pattern' => $pattern,
			'callback' => $callback
		];

	}

	/**
	 *	patternCapture
	 *
	 *	Creates named capture.
	 *
	 *	@param string $parameter Capture reference name.
	 *	@param string $expression Capture regular expression.
	 *	@param string $prefix Regular expression before capture.
	 *	@param string $suffix Regular expression after capture.
	 *
	 *	@return string
	 */
	public function patternCapture($parameter, $expression, $prefix = null, $suffix = null) {

		return $prefix . '(?P<' . $parameter . '>' . $expression . ')' . $suffix;

	}

	/**
	 *	patternCaptureDelimiter
	 *
	 *	Creates named capture within delimiters.
	 *
	 *	@param string $parameter Capture reference name.
	 *	@param string $expression Capture regular expression.
	 *	@param string $prefix Regular expression before capture.
	 *	@param string $suffix Regular expression after capture.
	 *
	 *	@return string
	 */
	public function patternCaptureDelimiter($parameter, $expression, $prefix = null, $suffix = null) {

		return self::OPENING_DELIMITER . $this->patternCapture($parameter, $expression, $prefix, $suffix) . self::CLOSING_DELIMITER;

	}

	/**
	 *	patternReference
	 *
	 *	Creates capture reference, useful for opening and closing blocks.
	 *
	 *	@param int $captureIndex Regular expression capture index.
	 *	@param string $prefix Regular expression before capture.
	 *	@param string $suffix Regular expression after capture.
	 *
	 *	@return string
	 */
	public function patternReference($captureIndex, $prefix = null, $suffix = null) {

		return $prefix . '\\' . $captureIndex . $suffix;

	}

	/**
	 *	patternReferenceDelimiter
	 *
	 *	Creates capture reference within opening and closing delimiters, useful for opening and closing blocks.
	 *
	 *	@param int $captureIndex Regular expression capture index.
	 *	@param string $prefix Regular expression before capture.
	 *	@param string $suffix Regular expression after capture.
	 *
	 *	@return string
	 */
	public function patternReferenceDelimiter($captureIndex, $prefix = null, $suffix = null) {

		return self::OPENING_DELIMITER . $this->patternReference($captureIndex, $prefix, $suffix) . self::CLOSING_DELIMITER;

	}

	/**
	 *	compile
	 *
	 *	Iterates through each registered node and invokes node callback.
	 *
	 *	@param string $template Template data.
	 *
	 *	@return string
	 */
	public function compile($template) {

		$view = $this->view;

		if(count($this->nodes) > 0) {

			foreach($this->nodes as $nodeName => $node) {

				$callback = $node->callback;

				$template = preg_replace_callback($node->pattern, function($matches) use ($callback, $view) {

					return call_user_func_array($callback, [(object) $matches, $view]);

				}, $template);

			}

		}

		return $template;

	}

	public function render(View $view) {

		$this->view = $view;

		return $this->compile($view->template());

	}

}