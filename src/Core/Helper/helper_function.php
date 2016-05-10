<?php

if (!function_exists("arr_get")) {
    /**
     * @param $arr
     * @param $key
     * @return array
     */
    function arr_get($arr, $key)
    {
        return \JayaCode\Framework\Core\Helper\HelperArray::getVal($arr, $key);
    }
}

if (!function_exists("arr_has_key")) {
    /**
     * @param $arr
     * @param $key
     * @return bool
     */
    function arr_has_key($arr, $key)
    {
        return \JayaCode\Framework\Core\Helper\HelperArray::hasKey($arr, $key);
    }
}

if (!function_exists("is_arr")) {
    /**
     * @param $arr
     * @return bool
     */
    function is_arr($arr)
    {
        return \JayaCode\Framework\Core\Helper\HelperArray::isArray($arr);
    }
}
