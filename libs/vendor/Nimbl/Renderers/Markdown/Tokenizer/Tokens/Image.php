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
 *	Image
 *
 *	Token for images.
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
class Image extends \Nimbl\Renderers\Markdown\Tokenizer\Token {

	/**
	 *	@var string $pattern Token regular expression.
	 */
	protected $pattern = '/(!\[(.*?)\]\([ \t]*<?(\S+?)>?[ \t]*(([\'\"])(.*?)\\5[ \t]*)?\))/xs';

	/**
	 *	@var string $decoration Tokenized token decoration, replacement pattern for {@see Token::$pattern}, uses sprintf.
	 */
	protected $decoration = '<img src="%s" alt="%s"%s/>';

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

		$alt = trim($matches[2]);

		$src = trim($matches[3]);

		$title = null;

		if(array_key_exists(6, $matches) === true) {

			$title = trim($matches[6]);

		}

		if(is_null($title) === false) {

			$title = " title=\"{$title}\" ";

		}

		return sprintf($this->decoration, $src, $alt, $title);

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