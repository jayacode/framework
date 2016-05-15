<?php
namespace JayaCode\Framework\Core\Helper\HelperArray;

/**
 * Class ArrayH
 * @package JayaCode\Framework\Core\Helper\HelperArray
 */
class ArrayH
{
    /**
     * @var string
     */
    public static $pathSeparator = ".";

    /**
     * @param array $arr
     * @param $path
     * @param null $default
     * @return null
     * @throws \Exception
     */
    public static function get(array $arr, $path, $default = null)
    {
        if (!is_array($arr) || !isset($arr)) {
            throw new \Exception("Argument 1 passed to arr_get must be of the type array");
        }
        $val = $default;
        self::exploreAtPath($arr, $path, function (&$prosArr) use (&$val) {
            $val = $prosArr;
        });

        return $val ? $val : $default;
    }

    /**
     * @param array $arr
     * @param $path
     * @param callable $callback
     * @param array|null $prosArr
     */
    private static function exploreAtPath(array &$arr, $path, callable $callback, array &$prosArr = null)
    {
        if ($prosArr === null) {
            $prosArr = &$arr;
            if (is_string($path) && $path == '') {
                $callback($prosArr);
                return;
            }
        }

        $explodedPath = explode(self::$pathSeparator, $path);
        $nextPath = array_shift($explodedPath);

        if (count($explodedPath) > 0) {
            self::exploreAtPath(
                $arr,
                implode(self::$pathSeparator, $explodedPath),
                $callback,
                $prosArr[$nextPath]
            );
        } else {
            $callback($prosArr[$nextPath]);
        }
    }

    /**
     * merge all array, if it has the same key number, the value will override
     * @param array $arr
     * @param $arr2
     * @return array
     */
    public static function arrMergeAll(array &$arr, $arr2)
    {
        if (is_array($arr2)) {
            foreach ($arr2 as $key => $val) {
                $arr[$key] = $val;
            }
        } else {
            $arr[] = $arr2;
        }

        return $arr;
    }

    /**
     * Return all array elements except for a given key
     * @param array $arr
     * @param array $excludeKeys
     * @return array
     */
    public static function arrExclude(array $arr, array $excludeKeys)
    {
        $result = [];
        foreach ($arr as $key => $val) {
            if (!in_array($key, $excludeKeys)) {
                $result[$key] = $val;
            }
        }
        return $result;
    }
}
