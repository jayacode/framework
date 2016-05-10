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
    public $id;

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
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     */
    public function __construct(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {

        $this->path = $path;
        $this->action = $action;
        $this->id = $id;
        $this->controller = $controller;
        $this->method = $method;
        $this->middleware = $middleware;
        $this->validation = $validation;
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function create(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }


    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function get(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "GET",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function post(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "POST",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function put(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "PUT",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    public static function head(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "HEAD",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function delete(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "DELETE",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function options(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "OPTIONS",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }

    /**
     * @param $id
     * @param $path
     * @param $action
     * @param string $controller
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function connect(
        $id,
        $path,
        $action,
        $controller = null,
        $method = "CONNECT",
        $middleware = null,
        $validation = null
    ) {
        return new static($id, $path, $action, $controller, $method, $middleware, $validation);
    }
}
