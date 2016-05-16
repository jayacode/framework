<?php
namespace JayaCode\Framework\Core\Route;

use JayaCode\Framework\Core\Application\Application;
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
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Application
     */
    protected $app;

    /**
     * Route constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->initialize($app);
    }

    /**
     * initialize Route
     * @param Application $app
     */
    public function initialize(Application $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->response = $app->response;
    }

    /**
     * Create Route object from static function
     * @param Application $app
     * @return RouteHandle
     */
    public static function create(Application $app)
    {
        return new RouteHandle($app);
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
            $this->response->setNotFound();
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
        $this->response->setDataContent($content);
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

        $controller = new $controllerName($this->app);

        $actionMethod = $route->action["method"];

        if (!method_exists($controller, $actionMethod)) {
            throw new \InvalidArgumentException("method " . $actionMethod . " not found");
        }

        $content = $controller->$actionMethod($this->request);
        $this->response->setDataContent($content);
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
