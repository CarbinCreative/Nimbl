Nimbl 1.0 Documentation
=======================

This documentation covers Nimbl version __1.x__.


## Getting Started
First off, you'll need to download the latest version of Nimbl from [the Github Repository](https://github.com/CarbinCreative/Nimbl/). After that there is no more setup. You might, however want to create a `.htaccess`-file with the following commands.

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /index.php?/$1 [L]


***

## Nimbl API functions

Nimbl comes with a very small set of helper functions.

__path__(`$path, $appendDirectorySeparator = false, $separator = '/'`)

_Replaces separator in input path string with DIRECTORY_SEPARATOR._

__import__(`$package`)

_Imports a package in libs/vendor._

__url__(`void`)

_Returns full URL._

__uri__(`$uri = null`)

_Either returns request URI if no argument is provided or returns a valid URI string._

__slug__(`$string, $delimiter = '-'`)

_Returns an URI friendly "slug" from a string._


***

## Routing

Nimbl is **REST**ful, therefore adding routes are as expected, valid HTTP request methods are as follows, `GET`, `POST`, `PUT`, `DELETE`, `HEAD` and `OPTIONS`. Nimbl also allow `ANY`, which means either of the request methods mentioned before.

Defining a new route is done by calling the request method (in lowercase) you want for the specific route, and then defining a route, and callback. There is an optional parameter for filter callbacks.

Here's a very simple route definiton;

    Nimbl\Router::get('/coffee', function() { /* Code here */ });
    // or
    Nimbl\Router::options('/tea', function() { /* Code here */ });

The second parameter is `callable` type hint introduced in PHP 5.4, therefore you can either pass in an anonymous function, a string (`MyClass::myMethod`) or even an array (`[$myObject, 'myMethod']`). This also applies to the third parameter which is _filter_.

### Filtering Routes
Route filters are just a simple (or not) callback which **MUST** return a boolean value based upon a set of rules whether or not the route callback can be invoked or not.

Defining a new filter could be something like this;

  Nimbl\Router::post('/data', 'App::postData', function() {

      return (userIsLoggedIn() && dataIsValid());

  });

### Regular Expressions

Nimbl has support for regular expressions in route paths, regex captures are passed through as arguments for callback functions.
It may look something like this;

	Nimbl\Router::get('/user/(\w+)', 'App::showUser', function($username) {

		return renderView('profilePage', $username);

  });