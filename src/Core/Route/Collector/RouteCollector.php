<?php
namespace JayaCode\Framework\Core\Route\Collector;

use JayaCode\Framework\Core\Route\Route;

/**
 * Interface RouteCollector
 * @package JayaCode\Framework\Core\Route\Collector
 */
interface RouteCollector
{
    /**
     * @param Route $route
     */
    public function addRoute(Route $route);

    /**
     * @return mixed
     */
    public function getData();
}
