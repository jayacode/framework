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
     * @var array | callable
     */
    public $action;

    /**
     * @var string
     */
    public $key;

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
     * @param string $method
     * @param string $middleware
     * @param string $validation
     */
    public function __construct($key, $path, $action, $method = "GET", $middleware = null, $validation = null)
    {
        $this->path = $path;
        $this->action = $action;
        $this->key = $key;
        $this->method = $method;
        $this->middleware = $middleware;
        $this->validation = $validation;
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $method
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function create($key, $path, $action, $method = "GET", $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, $method, $middleware, $validation);
    }


    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function get($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "GET", $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return Route
     */
    public static function post($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "POST", $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function put($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "PUT", $middleware, $validation);
    }

    public static function head($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "HEAD", $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function delete($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "DELETE", $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function options($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "OPTIONS", $middleware, $validation);
    }

    /**
     * @param $key
     * @param $path
     * @param $action
     * @param string $middleware
     * @param string $validation
     * @return static
     */
    public static function connect($key, $path, $action, $middleware = null, $validation = null)
    {
        return new static($key, $path, $action, "CONNECT", $middleware, $validation);
    }
}
