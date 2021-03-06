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
 *	BlockQuote
 *
 *	Token for blockquotes.
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
class BlockQuote extends \Nimbl\Renderers\Markdown\Tokenizer\Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern = '/\n(&gt;|\>)(.*)/';

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration = "\n<blockquote>%s</blockquote>";

	/**
	 *	@var string $sanitizePattern Token cleanup regular expression.
	 */
	protected $sanitizePattern = '/<\/blockquote><blockquote>/';

	/**
	 *	@var string $sanitizeDecoration Token cleanup decoration, replacement pattern for {@see Token::$sanitizePattern}, uses sprintf.
	 */
	protected $sanitizeDecoration = "\n";

	/**
	 *	callback
	 *
	 *	Must return decorated token.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public function callback($matches) {

		$match = array_pop($matches);

		return sprintf($this->decoration, trim($match));

	}

	/**
	 *	sanitize
	 *
	 *	Must return sanitized token.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public function sanitize($matches) {

		$match = array_pop($matches);

		return preg_replace($this->sanitizePattern(), $this->sanitizeDecoration, trim($match));

	}

}
?>