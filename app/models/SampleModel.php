<?php
/* required namespace app */
namespace app;

/* Sample Model */
class SampleModel implements \Nimbl\MVC\ModelInterface {

	public function fetchEntries() {

		return [
			'foo' => (object) [
				'title' => 'Entry Title : Foo',
				'body' => 'Lorem ipsum dolor &mdash; Foo'
			],
			'bar' => (object) [
				'title' => 'Entry Title : Bar',
				'body' => 'Lorem ipsum dolor &mdash; Bar'
			],
			'baz' => (object) [
				'title' => 'Entry Title : Baz',
				'body' => 'Lorem ipsum dolor &mdash; Baz'
			]
		];

	}

}