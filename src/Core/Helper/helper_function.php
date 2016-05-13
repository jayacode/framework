<?php

if (!function_exists("arr_get")) {
    /**
     * @param $arr
     * @param $path
     * @param $default
     * @return array
     */
    function arr_get($arr, $path, $default = null)
    {
        return \JayaCode\Framework\Core\Helper\HelperArray\ArrayH::get($arr, $path, $default);
    }
}
