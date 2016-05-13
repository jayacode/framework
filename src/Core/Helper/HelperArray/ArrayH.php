<?php
namespace JayaCode\Framework\Core\Helper\HelperArray;

class ArrayH
{
    public static $pathSeparator = ".";

    public static function get($arr, $path, $default = null)
    {
        $val = $default;
        self::exploreAtPath($arr, $path, function (&$prosArr) use (&$val) {
            $val = $prosArr;
        });

        return $val;
    }

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
}
