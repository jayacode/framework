<?php
namespace JayaCode\Framework\Core\Route\Dispatcher;

use JayaCode\Framework\Core\Route\Collector\RouteCollector;
use JayaCode\Framework\Core\Route\Route;
use JayaCode\Framework\Core\Route\Status;

/**
 * Class RegexDispatcher
 * @package JayaCode\Framework\Core\Route\Dispatcher
 */
class RegexDispatcher implements Dispatcher
{
    /**
     * @var RouteCollector
     */
    protected $routeCollector;

    /**
     * @var null
     */
    protected $data;
    /**
     * @var
     */
    protected $path;

    /**
     * @var array
     */
    protected $explodedPath;

    /**
     * @var
     */
    protected $httpMethod;

    /**
     * @param RouteCollector $routeCollector
     * @param null $data
     */
    public function __construct(RouteCollector $routeCollector, $data = null)
    {
        $this->routeCollector = $routeCollector;
        $this->data = $data;
    }

    /**
     * @param $httpMethod
     * @param $path
     * @return array|mixed
     */
    public function dispatch($httpMethod, $path)
    {
        $this->setPath($path);
        $this->httpMethod = $httpMethod;

        $data = is_null($this->data)?$this->routeCollector->getData():$this->data;
        return $this->findDataFromAllRoute($data);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function findDataFromAllRoute(array $data)
    {
        $result = [
            Status::NOT_FOUND
        ];

        $countData = count($data);
        $countExplodePath = count($this->explodedPath);

        for ($i=0; $result[0] == Status::NOT_FOUND && $countData > $i; $i++) {
            $this->findDataByRouteMethodAndRulePath($data[$i], $countExplodePath, $result);
        }

        return $result;
    }

    /**
     * @param Route $route
     * @param $countExplodePath
     * @param array $result
     */
    protected function findDataByRouteMethodAndRulePath(Route $route, $countExplodePath, array &$result)
    {
        if ($this->httpMethod == $route->method && $countExplodePath == count($route->explodePath)) {
            $this->findDataByAllMatchesRulePath($route, $countExplodePath, $result);

            if ($result[0] == Status::FOUND) {
                $result[1] = $route->handle;
            }
        }
    }

    /**
     * @param Route $route
     * @param $countExplodePath
     * @param array $result
     */
    protected function findDataByAllMatchesRulePath(Route $route, $countExplodePath, array &$result)
    {
        $result[0] = Status::FOUND;
        if ($this->path != $route->path) {
            for ($j = 0; $j < $countExplodePath && $result[0] == Status::FOUND; $j++) {
                $this->findDataByMatchesRulePath($route, $j, $result);
            }
        }
    }

    /**
     * @param Route $route
     * @param $index
     * @param array $result
     */
    protected function findDataByMatchesRulePath(Route $route, $index, array &$result)
    {
        $countMatches = count($route->ruleMatches[$index]);

        if ($countMatches == 0 ||
            $countMatches == 2 && $this->explodedPath[$index] != $route->explodePath[$index] ||
            $countMatches == 5 &&
            !preg_match("/^".$route->ruleMatches[$index][4]."$/", $this->explodedPath[$index])) {
            $result[0] = Status::NOT_FOUND;
        } elseif ($countMatches == 3 || $countMatches == 5) {
            $result[2][$route->ruleMatches[$index][2]] = $this->explodedPath[$index];
        }
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = static::normalizePath($path);

        $this->explodedPath = static::explodePath($this->path);
    }

    /**
     * @param $path
     * @return string
     */
    public static function normalizePath($path)
    {
        $path = trim($path, '/');
        return $path == ""?'/':$path;
    }

    /**
     * @param $path
     * @return array
     */
    public static function explodePath($path)
    {
        return (array) explode("/", $path);
    }
}
