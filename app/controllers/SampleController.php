<?php
/* required namespace app */
namespace app;

/* Sample Controller */
class SampleController implements \Nimbl\MVC\ControllerInterface {

	public static function index() {

		echo "Hello World!";

	}

	public static function error() {

		echo "Oops!";

	}

}