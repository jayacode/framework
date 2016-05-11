<?php
namespace JayaCode\Framework\Core\Route;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;

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

        if (!is_null($route) && is_callable($route->action)) {
            // if use callback function
            $this->handleCallback($route->action);
        } elseif (!is_null($route) && $route->controller && is_string($route->action)) {
            // if use controller
            $this->handleController($route);
        } else {
            $this->response->setNotFound($path);
        }

        return $this->response;
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
        $controller_class = "App\\Controller\\" . $route->controller;

        if (!class_exists($controller_class)) {
            throw new \InvalidArgumentException("controller " . $controller_class . " not found");
        }

        $controller = new $controller_class($this->request, $this->response);

        $action = $route->action;

        if (!method_exists($controller, $action)) {
            throw new \InvalidArgumentException("method " . $action . " not found");
        }

        $content = $controller->$action();
        $this->response->setContent($content);
    }

    /**
     * @param string $id
     * @return Route
     */
    public function getRoute($id = null)
    {
        if (is_null($id)) {
            return $this->routes;
        }

        if (!is_string($id)) {
            throw new \InvalidArgumentException("var id must be a string");
        }

        foreach ($this->routes as $route) {
            if ($route->id == $id) {
                return $route;
            }
        }

        throw new \OutOfBoundsException("not found route with id " . $id);
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
