<?php

use JayaCode\Framework\Core\Helper\HelperArray\ArrayH;

if (!function_exists("arr_get")) {
    /**
     * @param $arr
     * @param $path
     * @param $default
     * @return array
     */
    function arr_get($arr, $path, $default = null)
    {
        return ArrayH::get($arr, $path, $default);
    }

    function arr_push(&$arr, $arr2)
    {
        return ArrayH::arrPush($arr, $arr2);
    }
}
