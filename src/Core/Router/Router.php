<?php
namespace JayaCode\Framework\Core\Router;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;

class Router
{
    /**
     * @var array
     */
    public $routes = array(
        [
            "id"    => "home",
            "path"  => "/",
            "controller"    => "HomeController",
            "action"        => "index"
        ]
    );

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request &$request = null, Response &$response = null)
    {
        $this->initialize($request, $response);
    }

    /**
     * initialize Router
     * @param Request $request
     * @param Response $response
     */
    public function initialize(Request &$request = null, Response &$response = null)
    {
        $this->request = &$request;
        $this->response = &$response;
    }

    /**
     * Create Router object from static function
     * @param Request $request
     * @param Response $response
     * @return Router
     */
    public static function create(Request &$request = null, Response &$response = null)
    {
        return new Router($request, $response);
    }

    /**
     * Handle request
     */
    public function handle()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $route = $this->getRouteByPath($path, $method);

        if (!arr_has_key($route, "action")) {
            throw new \Exception("not found action for route id : " . arr_get($route, "id"));
        }

        $action = arr_get($route, "action");

        if (is_callable($action)) {
            // if use callback function
            $this->handleCallback($action);
        } elseif (arr_has_key($route, "controller") && is_string($action)) {
            // if use controller
            $this->handleController($route);
        } else {
            $this->response->setNotFound($path);
        }

        return $this->response;
    }

    private function handleCallback($func)
    {
        $content = call_user_func($func);
        $this->response->setContent($content);
    }

    /**
     * Handle Controller
     * @param $route
     */
    private function handleController($route)
    {
        $controller_class = "App\\Controller\\" . arr_get($route, "controller");

        if (!class_exists($controller_class)) {
            throw new \InvalidArgumentException("controller " . $controller_class . " not found");
        }

        $controller = new $controller_class($this->request, $this->response);

        $action = arr_get($route, "action");

        if (!method_exists($controller, $action)) {
            throw new \InvalidArgumentException("method " . $action . " not found");
        }

        $content = $controller->$action();
        $this->response->setContent($content);
    }

    /**
     * @param string $id
     * @return array
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
            if (arr_has_key($route, "id") && arr_get($route, "id") == $id) {
                return $route;
            }
        }

        throw new \OutOfBoundsException("not found route with id " . $id);
    }

    /**
     * @param string $path
     * @param string $method
     * @return array
     */
    public function getRouteByPath($path, $method)
    {

        foreach ($this->routes as $route) {
            if (arr_get($route, "path") == $path && arr_get($route, "method", "GET") == $method) {
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
