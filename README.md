Nimbl
=====

Nimbl is a micro framework written in PHP 5.4.



Getting Started
---------------

Nimbl is REST-ful, so adding new routes is very easy. Routes also accept _Regular Expressions_, which is pretty nice.

You can add routes to `ANY` or one of `GET`, `POST`, `PUT` or `DELETE`.

	Nimbl\Router::get('/blog', function() {

		list_blog_entries();

	});

	Nimbl\Router::delete('/blog/entry/(\d+)', function($id) {

		delete_blog_entry($id);

	});