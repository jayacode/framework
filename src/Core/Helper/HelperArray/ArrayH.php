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
     * @param $arr
     * @param $path
     * @param null $default
     * @return null
     */
    public static function get($arr, $path, $default = null)
    {
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
     * @param $arr
     * @return array
     */
    public static function arrPush(&$arr)
    {
        foreach (func_get_args() as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $key => $val) {
                    if (!is_numeric($key)) {
                        $arr[$key] = $val;
                    } else {
                        $arr[] = $val;
                    }
                }
            } else {
                $arr[] = $arg;
            }
        }

        return $arr;
    }
}
