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

/* @namespace ViewAdapters */
namespace Nimbl\MVC\ViewAdapters;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;



/**
 *	Markdown
 *
 *	Markdown view adapter.
 *
 *	@package Nimbl
 *	@subpackage MVC
 *	@subpackage ViewAdapters
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Markdown extends \Nimbl\MVC\ViewAbstract {

	protected $tokenizer;

	/**
	 *	Constructor
	 *
	 *	Registers Markdown tokenizer tokens.
	 *
	 *	@return void
	 */
	public function __construct() {

		$this->tokenizer = new \Nimbl\Renderers\Markdown\Tokenizer();

		$this->tokenizer->registerToken('hardBreak', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\HardBreak());
		$this->tokenizer->registerToken('heading', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Heading());
		$this->tokenizer->registerToken('image', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Image());
		$this->tokenizer->registerToken('variable', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Variable());
		$this->tokenizer->registerToken('inlineCode', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\InlineCode());
		$this->tokenizer->registerToken('blockCode', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\BlockCode());
		$this->tokenizer->registerToken('anchor', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Anchor());
		$this->tokenizer->registerToken('wikiAnchor', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\WikiAnchor());
		$this->tokenizer->registerToken('strong', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Strong());
		$this->tokenizer->registerToken('emphasis', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Emphasis());
		$this->tokenizer->registerToken('unorderedList', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\UnorderedList());
		$this->tokenizer->registerToken('orderedList', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\OrderedList());
		$this->tokenizer->registerToken('inlineQuote', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\InlineQuote());
		$this->tokenizer->registerToken('blockQuote', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\BlockQuote());
		$this->tokenizer->registerToken('paragraph', new \Nimbl\Renderers\Markdown\Tokenizer\Tokens\Paragraph());

	}

	/**
	 *	output
	 *
	 *	Renders and outputs markdown as HTML.
	 *
	 *	@param string $rawData Unrendered view string.
	 *
	 *	@return string
	 */
	public function output($rawData) {

		$output = $this->tokenizer->tokenize($rawData);

		return $this->tokenizer->sanitize($output);

	}

	/**
	 *	render
	 *
	 *	Renders markdown files into HTML.
	 *
	 *	@param string $viewFile Unrendered view file.
	 *
	 *	@return string
	 */
	public function render($viewFile) {

		if(file_exists($viewFile) === true) {

			$viewData = file_get_contents($viewFile);

			$output = $this->tokenizer->tokenize($viewData);

			return $this->tokenizer->sanitize($output);

		}

		return null;

	}

}