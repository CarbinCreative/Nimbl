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
 *	Paragraph
 *
 *	Token for paragraphs.
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
class Paragraph extends \Nimbl\Renderers\Markdown\Tokenizer\Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern = '/\n([^\n]+)/';

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration = "\n<p>%s</p>\n";

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

		$line = trim($matches[1]);

		if(strpos($line, '<') === 0) {

			return $matches[1];

		}

		return sprintf($this->decoration, $line);

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