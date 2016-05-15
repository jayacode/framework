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
}

if (!function_exists("arr_merge_all")) {
    /**
     * @param $arr
     * @param $arr2
     * @return array
     */
    function arr_merge_all(&$arr, $arr2)
    {
        return ArrayH::arrMergeAll($arr, $arr2);
    }
}
