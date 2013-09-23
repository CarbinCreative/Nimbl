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

/* @namespace Nimbl */
namespace Nimbl;

/* Deny direct file access */
if(!defined('NIMBL_ROOT_PATH')) exit;

/**
 *	View
 *
 *	Very simple mustache-ish templating engine.
 *
 *	@package Nimbl
 *
 *	@version 1.0
 *
 *	@author Robin Grass <http://uiux.se/>
 */
class View {

	const OPENING_DELIMITER = '{{';

	const CLOSING_DELIMITER = '}}';

	protected $tags = [];

	protected $variables = [];

	public function registerTemplateLogic($templateLogic, Callable $templateHandler) {

		$this->tags[$templateLogic] = $templateHandler;

	}

	public function render($template) {

		foreach($this->tags as $templateLogic => $templateHandler) {

			$template = preg_replace_callback($templateLogic, function($matches) use ($templateHandler) {

				return call_user_func_array($templateHandler, [(object) $matches, $this]);

			}, $template);

		}

		return $template;

	}

}