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

/* @namespace Tokenizer */
namespace Nimbl\Renderers\Markdown\Tokenizer;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Tokenizer
 *
 *	Tokenizer object which converts markdown-styled documents into HTML.
 *
 *	@package Nimbl
 *	@subpackage Renderers
 *	@subpackage Markdown
 *	@subpackage Tokenizer
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
abstract class Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern;

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration;

	/**
	 *	@var string $sanitizePattern Token cleanup regular expression.
	 */
	protected $sanitizePattern;

	/**
	 *	@var string $sanitizeDecoration Token cleanup decoration, replacement pattern for {@see Token::$sanitizePattern}, uses sprintf.
	 */
	protected $sanitizeDecoration;

	/**
	 *	pattern
	 *
	 *	Returns token regular expression.
	 *
	 *	@return string
	 */
	public function pattern() {

		return $this->pattern;

	}

	/**
	 *	decoration
	 *
	 *	Returns token decoration.
	 *
	 *	@return string
	 */
	public function decoration() {

		return $this->decoration;

	}

	/**
	 *	sanitizePattern
	 *
	 *	Returns token sanitizer regular expression.
	 *
	 *	@return string
	 */
	public function sanitizePattern() {

		return $this->sanitizePattern;

	}

	/**
	 *	sanitizeDecoration
	 *
	 *	Returns token sanitizer decoration.
	 *
	 *	@return string
	 */
	public function sanitizeDecoration() {

		return $this->sanitizeDecoration;

	}

	/**
	 *	callback
	 *
	 *	Must return decorated token.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public abstract function callback($matches);

	/**
	 *	sanitize
	 *
	 *	Must return sanitized token.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public abstract function sanitize($matches);

}