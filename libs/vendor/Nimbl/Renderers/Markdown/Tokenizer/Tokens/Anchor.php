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

/* @namespace Markdown */
namespace Nimbl\Renderers\Markdown\Tokenizer\Tokens;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	Anchor
 *
 *	Token for anchors.
 *
 *	@package Nimbl
 *	@subpackage Renderers
 *	@subpackage Markdown
 *	@subpackage Tokenizer
 *	@subpackage Tokens
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Anchor extends \Nimbl\Renderers\Markdown\Tokenizer\Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern = '/\[([^\[]+)\]\(([^\)]+)\)/';

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration = '<a href="%s" title="%s">%s</a>';

	/**
	 *	callback
	 *
	 *	Returns decorated anchor token.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public function callback($matches) {

		$link = array_pop($matches);

		$title = array_pop($matches);

		return sprintf($this->decoration, trim($link), trim($title), trim($title));

	}

	/**
	 *	sanitize
	 *
	 *	Cleanup not required for anchors.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public function sanitize($matches) {}

}
?>