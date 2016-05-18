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
    protected $routeCollector;

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

        $result = [
            Status::NOT_FOUND
        ];

        $data = is_null($this->data)?$this->routeCollector->getData():$this->data;
        $countData = count($data);
        $countExplodePath = count($this->explodedPath);

        $i = 0;
        while ($result[0] == Status::NOT_FOUND && $countData > $i) {
            /** @var Route $route */
            $route = $data[$i];

            if ($this->httpMethod == $route->method && $countExplodePath == count($route->explodePath)) {
                $result[0] = Status::FOUND;
                if ($this->path != $route->path) {
                    for ($j = 0; $j < $countExplodePath && $result[0] == Status::FOUND; $j++) {
                        $countMatches = count($route->ruleMatches[$j]);

                        if ($countMatches == 0 ||
                            $countMatches == 2 && $this->explodedPath[$j] != $route->explodePath[$j] ||
                            $countMatches == 5 &&
                            !preg_match("/^".$route->ruleMatches[$j][4]."$/", $this->explodedPath[$j])) {
                            $result[0] = Status::NOT_FOUND;
                        } elseif ($countMatches == 3 || $countMatches == 5) {
                            $result[2][$route->ruleMatches[$j][2]] = $this->explodedPath[$j];
                        }
                    }
                }


                if ($result[0] == Status::FOUND) {
                    $result[1] = $route->handle;
                }
            }

            $i++;
        }

        return $result;
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
