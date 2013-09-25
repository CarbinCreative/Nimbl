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
namespace Nimbl\Renderers\Markdown;

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
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Tokenizer {

	/**
	 *	@var array $tokens Token store.
	 */
	protected $tokens = [];

	/**
	 *	registerToken
	 *
	 *	Registers token object.
	 *
	 *	@param string $identifier Token identifier
	 *	@param \Paperless\Tokenizer\Token $token Tokenizer object
	 *
	 *	@return void
	 */
	public function registerToken($identifier, Tokenizer\Token $token) {

		$this->tokens[$identifier] = $token;

	}

	/**
	 *	tokenize
	 *
	 *	Tokenizes string.
	 *
	 *	@param string $string Untokenized string.
	 *
	 *	@return string
	 */
	public function tokenize($string) {

		$string = implode('', ["\n", trim($string), "\n"]);

		foreach($this->tokens as $identifier => $token) {

			$string = preg_replace_callback($token->pattern(), [$token, 'callback'], $string);

		}

		return trim($string);

	}

	/**
	 *	sanitize
	 *
	 *	Sanitizes string using token sanitizers, if present.
	 *
	 *	@param string $string Untokenized string.
	 *
	 *	@return string
	 */
	public function sanitize($string) {

		foreach($this->tokens as $identifier => $token) {

			if(is_string($token->sanitizePattern()) === true) {

				$string = preg_replace_callback($token->sanitizePattern(), [$token, 'sanitize'], $string);

			}

		}

		return trim($string);

	}

}