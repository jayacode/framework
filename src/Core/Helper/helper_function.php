<?php

use JayaCode\Framework\Core\Helper\Config\Config;
use JayaCode\Framework\Core\Helper\HelperArray\ArrayH;

if (!function_exists("arr_get")) {
    /**
     * @param array $arr
     * @param $path
     * @param $default
     * @return array
     * @throws Exception
     */
    function arr_get(array $arr, $path, $default = null)
    {
        return ArrayH::get($arr, $path, $default);
    }
}

if (!function_exists("arr_merge_all")) {
    /**
     * @param array $arr
     * @param $arr2
     * @return array
     */
    function arr_merge_all(array &$arr, $arr2)
    {
        return ArrayH::arrMergeAll($arr, $arr2);
    }
}

if (!function_exists("arr_exclude")) {
    /**
     * @param array $arr
     * @param array $arr2
     * @return array
     */
    function arr_exclude(array $arr, array $arr2)
    {
        return ArrayH::arrExclude($arr, $arr2);
    }
}

if (!function_exists("config")) {
    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    function config($name, $default = null)
    {
        return Config::get($name, $default);
    }
}
