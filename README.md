Croute: Routes from class annotations

[![Build Status](https://api.travis-ci.org/magnus-eriksson/croute.svg)](https://travis-ci.org/magnus-eriksson/croute)

## Usage
- [Install](#Install)
- [Example](#Example)



## Install

Clone this repository or use composer to download the library with the following command:
```bash
$ composer require maer/croute
```

## Example

Clone this repository or use composer to download the library with the following command:
```php
// Your controller

class MyController
{
    /**
     * @route       GET /some-uri
     * @routeName   some-name
     * @routeBefore some_filter_name
     * @routeAfter  some_other_filter_name
     */
    public function someCallback()
    {
        // Do stuff
    }
}

// Create the Croute-instance and pass the absolute path to the controller
// or to the folder where all your controllers are
$croute = new Maer\Croute\Croute(['/path/to/MyController.php']);

// Get all defined routes
$routes = $croute->getRoutes();

// Returns:
array(1) {
  [0] =>
  object(Maer\Croute\Route) {
    ["name" ]    => "some-name"
    ["method"]   => "GET"
    ["route"]    => "/some-uri"
    ["callback"] => "MyController@someCallback"
    ["before"]   => [
      'some_filter_name',
    ]
    ["after"]    => [
      'some_other_filter_name',
    ]
  }
}
```

As you see, what you get back is a list of all the defined routes from the method annotations. Use your favorite router library to actually create the routes.

_...this documentation is a work in progress_
