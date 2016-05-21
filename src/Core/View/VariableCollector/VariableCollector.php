<?php
namespace JayaCode\Framework\Core\View\VariableCollector;

/**
 * Interface VariableCollector
 * @package JayaCode\Framework\Core\View\VariableCollector
 */
interface VariableCollector
{
    /**
     * @param $data
     */
    public function add($data);

    /**
     * @param $data
     */
    public function replace($data);

    /**
     * @return array
     */
    public function all();

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null);
}
