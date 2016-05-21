<?php
namespace JayaCode\Framework\Core\View;

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
