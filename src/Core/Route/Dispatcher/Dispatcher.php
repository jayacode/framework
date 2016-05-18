<?php
namespace JayaCode\Framework\Core\Route\Dispatcher;

/**
 * Interface Dispatcher
 * @package JayaCode\Framework\Core\Route\Dispatcher
 */
interface Dispatcher
{
    /**
     * @param $httpMethod
     * @param $uri
     * @return mixed
     */
    public function dispatch($httpMethod, $uri);
}
