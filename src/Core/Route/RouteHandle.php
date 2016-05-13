<?php
namespace JayaCode\Framework\Core\Route;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;

/**
 * Class RouteHandle
 * @package JayaCode\Framework\Core\Route
 */
class RouteHandle
{
    /**
     * @var array
     */
    public $routes = array();

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * Route constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request &$request = null, Response &$response = null)
    {
        $this->initialize($request, $response);
    }

    /**
     * initialize Route
     * @param Request $request
     * @param Response $response
     */
    public function initialize(Request &$request = null, Response &$response = null)
    {
        $this->request = &$request;
        $this->response = &$response;
    }

    /**
     * Create Route object from static function
     * @param Request $request
     * @param Response $response
     * @return RouteHandle
     */
    public static function create(Request &$request = null, Response &$response = null)
    {
        return new RouteHandle($request, $response);
    }

    /**
     * Handle request
     */
    public function handle()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $route = $this->getRouteByPath($path, $method);

        if (!$this->tryHandleRequest($route)) {
            $this->response->setNotFound($path);
        }

        return $this->response;
    }

    /**
     * Try to handle request if success return true
     * @param $route
     * @return bool
     */
    private function tryHandleRequest($route)
    {
        if (is_null($route)) {
            return false;
        }

        // is callback function
        if (is_callable($route->action)) {
            $this->handleCallback($route->action);
            return true;
        }

        // is class controller
        if (is_array($route->action) && arr_get($route->action, "controller") && arr_get($route->action, "method")) {
            $this->handleController($route);
            return true;
        }

        return false;
    }

    /**
     * Handle route with action callback
     * @param callable $func
     */
    private function handleCallback(callable $func)
    {
        $content = call_user_func($func);
        $this->response->setContent($content);
    }

    /**
     * Handle Controller
     * @param Route $route
     */
    private function handleController(Route $route)
    {
        $controllerName = "App\\Controller\\" . $route->action["controller"];

        if (!class_exists($controllerName)) {
            throw new \InvalidArgumentException("controller " . $controllerName . " not found");
        }

        $controller = new $controllerName($this->request, $this->response);

        $actionMethod = $route->action["method"];

        if (!method_exists($controller, $actionMethod)) {
            throw new \InvalidArgumentException("method " . $actionMethod . " not found");
        }

        $content = $controller->$actionMethod();
        $this->response->setContent($content);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getRoute($key = null)
    {
        if (is_null($key)) {
            return $this->routes;
        }

        if (!is_string($key)) {
            throw new \InvalidArgumentException("var key must be a string");
        }

        foreach ($this->routes as $route) {
            if ($route->key == $key) {
                return $route;
            }
        }

        throw new \OutOfBoundsException("not found route with key " . $key);
    }

    /**
     * @param string $path
     * @param string $method
     * @return Route
     */
    public function getRouteByPath($path, $method)
    {

        foreach ($this->routes as $route) {
            if ($route->path == $path && $route->method == $method) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param array $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
}
