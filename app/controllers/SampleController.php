<?php
/* required namespace app */
namespace app;

/* Sample Controller */
class SampleController implements \Nimbl\MVC\ControllerInterface {

	public static function index() {

		echo "Nimbl 1.1&beta;";

	}

	public static function native() {

		$model = new SampleModel();

		echo \Nimbl\Renderer::render('samples/native.php', [
			'title' => 'Native View Sample',
			'entries' => $model->fetchEntries()
		]);

	}

	public static function markdown() {

		echo \Nimbl\Renderer::render('samples/markdown.md');

	}

	public static function error() {

		echo "Oops!";

	}

}