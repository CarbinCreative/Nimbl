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
 *	Emphasis
 *
 *	Token for emphasis.
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
class Emphasis extends \Nimbl\Renderers\Markdown\Tokenizer\Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern = '/(?<!\S)[_|\*]{1}(\S.*?)[_|\*]{1}/';

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration = "<em>%s</em>";

	/**
	 *	callback
	 *
	 *	Returns decorated emphasis token.
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
	 *	Cleanup not required for headings.
	 *
	 *	@param array $matches Token regular expression matches.
	 *
	 *	@return string
	 */
	public function sanitize($matches) {}

}
?>