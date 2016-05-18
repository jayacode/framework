<?php
namespace JayaCode\Framework\Core\Route;

/**
 * Class Route
 * @property array explodePath
 * @property array ruleMatches
 * @method get(string $name, string $path, mixed $handle)
 * @method post(string $name, string $path, mixed $handle)
 * @method put(string $name, string $path, mixed $handle)
 * @method delete(string $name, string $path, mixed $handle)
 * @method head(string $name, string $path, mixed $handle)
 * @method options(string $name, string $path, mixed $handle)
 * @method connect(string $name, string $path, mixed $handle)
 * @package JayaCode\Framework\Core\Route
 */
class Route
{

    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $path;

    /**
     * @var
     */
    public $handle;

    /**
     * @var string
     */
    public $method;

    /**
     * @var array
     */
    public $ruleMatches = array();

    /**
     * @var
     */
    public $attributes;

    /**
     * Route constructor.
     * @param string $key
     * @param string $path
     * @param $handle
     * @param string $method
     */
    public function __construct($key, $path, $handle, $method)
    {
        $this->key = $key;
        $this->path = $path;
        $this->handle = $handle;
        $this->method = $method;
    }

    /**
     * @param $key
     * @param $path
     * @param $handle
     * @param string $method
     * @return static
     */
    public static function create($key, $path, $handle, $method = "GET")
    {
        return new static($key, $path, $handle, $method);
    }

    /**
     * @param $name
     * @param $arguments
     * @return Route
     */
    public static function __callStatic($name, $arguments)
    {
        if (count($arguments) != 3) {
            throw new \InvalidArgumentException();
        }

        $method = strtoupper($name);
        return static::create($arguments[0], $arguments[1], $arguments[2], $method);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new \OutOfBoundsException();
        }

        return $this->attributes[$name];
    }
}
