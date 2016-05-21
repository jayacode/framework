<?php
namespace JayaCode\Framework\Core\View;

use JayaCode\Framework\Core\Route\Collector\RegexRouteCollector;
use JayaCode\Framework\Core\Route\Dispatcher\Dispatcher;
use JayaCode\Framework\Core\Route\Dispatcher\RegexDispatcher;
use JayaCode\Framework\Core\View\View;

if (!function_exists('JayaCode\Framework\Core\View\templateEngine')) {

    /**
     * @param $viewDir
     * @param array $globalVariable
     * @param array $options
     * @return View
     */
    function templateEngine($viewDir, $globalVariable = [], $options = [])
    {
        return new View($viewDir, $globalVariable, $options);
    }
}
