<?php
namespace JayaCode\Framework\Core\View\VariableCollector;

/**
 * Class BasicVariableCollector
 * @package JayaCode\Framework\Core\View\VariableCollector
 */
class BasicVariableCollector implements VariableCollector
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * BasicVariableCollector constructor.
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @param $data
     */
    public function add($data)
    {
        $this->data = (array) $data + $this->data;
    }

    /**
     * @param $data
     */
    public function replace($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        return isset($this->data[$name])?$this->data[$name]:$default;
    }
}
