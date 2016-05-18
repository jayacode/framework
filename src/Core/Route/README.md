# JayaCode Route

jayacode route package

## Requirements
* PHP >= 5.5

## Usage
``` php
<?php
use JayaCode\Framework\Core\Route\Collector\RouteCollector;
use JayaCode\Framework\Core\Route\Dispatcher\Dispatcher;
use JayaCode\Framework\Core\Route\Route;
use JayaCode\Framework\Core\Route\Status;

require_once("vendor/autoload.php");

$routes = function (RouteCollector $route) {
    $route->addRoute(Route::get("home", "/", "handleHome"));
    $route->addRoute(Route::get("user.id", "/user/{id:[1-9]*}", "handleUserId"));
};

$httpMethod = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($path, '?')) {
    $path = substr($path, 0, $pos);
}
$uri = rawurldecode($path);

/** @var Dispatcher $dispatcher */
$dispatcher = JayaCode\Framework\Core\Route\dispatcherBasic($routes);

$result = $dispatcher->dispatch($httpMethod, $uri);

if ($result[0] == Status::FOUND) {
    // get handle
    var_dump($result[1]);

    // get variable
    if (isset($result[2])) {
        var_dump($result[2]);
    }
} else {
    echo "handle not found";
}
```

## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
