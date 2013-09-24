Nimbl
=====

Nimbl is a micro framework written in PHP 5.4.



### Getting Started

Nimbl is REST-ful, so adding new routes is very easy. Routes also accept _Regular Expressions_, which is pretty nice.

You can add routes to `ANY` or one of `GET`, `POST`, `PUT` or `DELETE`.

	Nimbl\Router::get('/blog', function() {

		list_blog_entries();

	});

	Nimbl\Router::delete('/blog/entry/(\d+)', function($id) {

		delete_blog_entry($id);

	});



### Template Engine (`*.nim`)

Nimbl comes with a very primitive templating engine, with moustache-ish syntax. With support for control structures, loops and variables. Check out [app\views\blog.nim](https://github.com/CarbinCreative/Nimbl/blob/master/app/views/blog.nim) for full template demo.



Changelog
---------

* __0.1-beta__
	* Initial version, simple routing only.
* __0.2-beta__
	* Added templating engine.
<<<<<<< HEAD
* __0.2.1-beta__
	* Added two new functions, `redirect` and `slug`.
=======
>>>>>>> 8246d3242c66e8c952d26dedb831ca596b88fd5e
