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
 *	Parser
 *
 *	Parser definition for *.nim templates.
 *
 *	@package Nimbl
 *	@subpackage Template
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class Parser {

	/**
	 *	@var \Nimbl\Template\Engine $engine Instance of {@see \Nimbl\Template\Engine}.
	 */
	protected $engine;

	/**
	 *	Constructor
	 *
	 *	Creates a new instance of {@see \Nimbl\Template\Engine} and invokes token handlers.
	 *
	 *	@return void
	 */
	public function __construct() {

		$this->engine = new Engine();

		$this->tokenCondition();

		$this->tokenLoop();

		$this->tokenVariable();

	}

	/**
	 *	tokenCondition
	 *
	 *	Token handler for control structres.
	 *
	 *	@return void
	 */
	protected function tokenCondition() {

		$engine = $this->engine;

		$expression = $engine->patternCaptureDelimiter('conditionName', '\w+', null, '\?');
		$expression .= $engine->patternCapture('conditionBody', '.*?');

		// 1 is the index of the capture, in this case 'conditonName'
		$expression .= $engine->patternReferenceDelimiter(1, '\/');

		$engine->registerNode('controlStructure', "/{$expression}/is", function($match, $view) use ($engine) {

			if(isset($match->conditionName) === true) {

				$variable = $match->conditionName;

				$segments = [$match->conditionName, null];

				$unlessExpression = $engine->patternCaptureDelimiter('unlessConditionBody', "({$match->conditionName})", '\!');

				if(preg_match("/{$unlessExpression}/", $match->conditionBody)) {

					$segments = preg_split("/{$unlessExpression}/", $match->conditionBody);

				}

				list($passed, $failed) = $segments;

				$property = $view->get($variable);

				if(isset($property) === true && $property !== false) {

					$renderMatch = $passed;

				} else {

					$renderMatch = $failed;

				}

				return $engine->compile($renderMatch);

			}

		});

	}

	/**
	 *	tokenLoop
	 *
	 *	Token handler for loop blocks.
	 *
	 *	@return void
	 */
	protected function tokenLoop() {

		$engine = $this->engine;

		$expression = $engine->patternCaptureDelimiter('loopName', '\w+', '\#');
		$expression .= $engine->patternCapture('loopBody', '.*?');

		// 1 is the index of the capture, in this case 'loopName'
		$expression .= $engine->patternReferenceDelimiter(1, '@');

		$engine->registerNode('loopBlock', "/{$expression}/is", function($match, $view) use ($engine) {

			$loop = $view->get($match->loopName);

			if(isset($match->loopName) === true && is_array($loop) === true) {

				$output = null;
				$cursor = 1;

				foreach($loop as $key => $item) {

					$view->cursor = $cursor++;

					if(is_string($item) === true) {

						$view->item = $item;

					} else if(is_array($item) === true) {

						foreach($item as $property => $data) {

							$loopBody = preg_replace('/(\w+)\.(\w+)/', '$1_$2', $match->loopBody);

							$_key = "{$match->loopName}_{$property}";

							$view->$_key = $data;

						}

						$output .= $engine->compile($loopBody);

					}

				}

				return $engine->compile($output);

			}

		});

	}

	/**
	 *	tokenVariable
	 *
	 *	Token handler for variables.
	 *
	 *	@return void
	 */
	protected function tokenVariable() {

		$engine = $this->engine;

		$expression = $engine->patternCaptureDelimiter('variableName', '\w+');

		$engine->registerNode('variable', "/{$expression}/i", function($match, $view) use ($engine) {

			$variableName = $match->variableName;

			if(isset($variableName) === true) {

				return $view->$variableName;

			}

		});

	}

	/**
	 *	render
	 *
	 *	Renders view.
	 *
	 *	@param \Nimbl\Template\View $view Instance of {@see \Nimbl\Template\View}.
	 *
	 *	@return string
	 */
	public function render(View $view) {

		return $this->engine->render($view);

	}

}