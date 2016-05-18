<?php
namespace JayaCode\Framework\Core\Route;

use JayaCode\Framework\Core\Route\Collector\RegexRouteCollector;
use JayaCode\Framework\Core\Route\Dispatcher\Dispatcher;
use JayaCode\Framework\Core\Route\Dispatcher\RegexDispatcher;

if (!function_exists('JayaCode\Framework\Core\RouteRoute\dispatcherBasic')) {
    /**
     * @param callable $definitionCollection
     * @param array $options
     * @return Dispatcher
     */
    function dispatcherBasic(callable $definitionCollection, $options = [])
    {
        $options += [
            "dispatcher" => RegexDispatcher::class,
            "routeCollection" => RegexRouteCollector::class
        ];

        $routeCollection = new $options["routeCollection"]();
        $definitionCollection($routeCollection);

        return new $options['dispatcher']($routeCollection);
    }
}
