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
        "home" => [
            "/",
            "HomeController",
            "index"
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
        $route = null;

        foreach ($this->routes as $key => $value) {
            if ($this->routes[$key][0] == $path) {
                $route = $this->routes[$key];
                break;
            }
        }

        if (!is_null($route)) {
            $controller_class = "App\\Controller\\" . $route[1];
            $controller = new $controller_class($this->request, $this->response);

            $content = $controller->$route[2]();
            $this->response->setContent($content);
        } else {
            $this->response->setStatusCode(404);
        }

        return $this->response;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
}
