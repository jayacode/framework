<?php
namespace JayaCode\Framework\Core\Helper;

class HelperArray
{
    public static function getVal($arr = array(), $key = "", $default = null)
    {
        $val = $arr;
        $i = 0;
        $keys = explode(".", $key);

        while ($i < count($keys)) {
            if (!HelperArray::hasKey($val, $keys[$i])) {
                return $default;
            }

            $val = $val[$keys[$i]];

            $i++;
        }

        return $val;
    }

    public static function hasKey($arr = array(), $key = "")
    {
        if (!HelperArray::isArray($arr)) {
            return false;
        }

        if (!is_string($key)) {
            throw new \InvalidArgumentException("Argument 2 must be a string");
        }

        return isset($arr[$key]);
    }

    public static function isArray($arr = array())
    {
        return is_array($arr);
    }
}
