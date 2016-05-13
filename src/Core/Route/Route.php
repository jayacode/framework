<?php
namespace JayaCode\Framework\Core\Route;

/**
 * Class Route
 * @package JayaCode\Framework\Core\Route
 */
class Route
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $middleware;

    /**
     * @var string
     */
    public $validation;

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     */
    public function __construct(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {

        $this->path = $path;
        $this->action = $action;
        $this->key = $key;
        $this->controller = $controller;
        $this->method = $method;
        $this->middleware = $middleware;
        $this->validation = $validation;
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function create(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }


    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function get(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function post(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "POST",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function put(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "PUT",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    public static function head(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "HEAD",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function delete(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "DELETE",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function options(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "OPTIONS",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function connect(
        $key,
        $path,
        $action,
        $controller = null,
        $method = "CONNECT",
        $middleware = null,
        $validation = null
    ) {
        return new static($key, $path, $action, $controller, $method, $middleware, $validation);
    }
}
