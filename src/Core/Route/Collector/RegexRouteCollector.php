<?php
namespace JayaCode\Framework\Core\Route\Collector;

use JayaCode\Framework\Core\Route\Dispatcher\RegexDispatcher;
use JayaCode\Framework\Core\Route\Route;

/**
 * Class RegexRouteCollector
 * @package JayaCode\Framework\Core\Route\Collector
 */
class RegexRouteCollector implements RouteCollector
{
    /**
     * @var string
     */
    protected $regex = '/^(\w+|\{(\w+)(\:([\w|\[|\-|\]|\\|\+|\?|\*|\^|\$|\||\.]+))?\})$/';

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @param Route $route
     * @throws \Exception
     */
    public function addRoute(Route $route)
    {
        $route->path = RegexDispatcher::normalizePath($route->path);
        $route->explodePath = RegexDispatcher::explodePath($route->path);

        foreach ($route->explodePath as $item) {
            $matches = array();
            preg_match($this->regex, $item, $matches);

            $count = count($matches);

            /**
             * path == "" // path / home
             * count == 2 // basic path ex: user
             * count == 3 // var path ex: {id}
             * count == 5 // var path with regex ex: {id:[1-9]*}
             */
            if ($route->path != "" && $count != 0 && $count != 2 && $count != 3 && $count != 5) {
                throw new \Exception("bad route! path : {$item} {$count}");
            }

            $route->ruleMatches[] = $matches;
        }

        $this->routes[] = $route;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->routes;
    }
}
