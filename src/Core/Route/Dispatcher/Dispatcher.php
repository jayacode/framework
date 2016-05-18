<?php
namespace JayaCode\Framework\Core\Route\Dispatcher;

interface Dispatcher
{
    public function dispatch($httpMethod, $uri);
}
