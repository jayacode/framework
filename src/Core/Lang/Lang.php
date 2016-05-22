<?php
namespace JayaCode\Framework\Core\Lang;

/**
 * Class Lang
 * @package JayaCode\Framework\Core\Lang
 */
class Lang
{
    /**
     * @var string
     */
    protected static $locale = 'eng';
    /**
     * @var string
     */
    protected static $localeDefault = "eng";

    /**
     * @var string
     */
    protected static $langDir = '/';

    /**
     * @var array
     */
    protected static $lang = [];

    /**
     * @param $locale
     */
    public static function setLocale($locale)
    {
        static::$locale = $locale;
    }

    /**
     * @param $dir
     * @throws \Exception
     */
    public static function setDir($dir)
    {
        static::$langDir = rtrim($dir, "/")."/";

        if (!is_dir(static::$langDir)) {
            throw new \Exception("folder lang not found");
        }
    }

    /**
     * @param $name
     * @param array $params
     * @param string $default
     * @return mixed|null|string
     */
    public static function get($name, $params = [], $default = "")
    {
        $nameArr = static::tryExplodeName($name);

        if (null !== $return = static::getFromArray(static::$lang, $nameArr, $params, null, false)) {
            return $return;
        }

        if (null !== $return = static::getFromFile($nameArr, $params, null, false)) {
            return $return;
        }

        $nameArrDef = $nameArr;
        $nameArrDef[0] = static::$localeDefault;

        if (null !== $return = static::getFromArray(static::$lang, $nameArrDef, $params, null, false)) {
            return $return;
        }
        if (null !== $return = static::getFromFile($nameArrDef, $params, null, false)) {
            return $return;
        }

        return $default;
    }

    /**
     * @param $arr
     * @param $name
     * @param array $params
     * @param null $default
     * @param bool $getFormDefault
     * @return mixed|null
     */
    public static function getFromArray($arr, $name, $params = [], $default = null, $getFormDefault = true)
    {
        $name = static::tryExplodeName($name);

        $result = static::searchArrayWithNameArray($arr, $name);

        if ($getFormDefault && $result === null && static::$localeDefault != static::$locale) {
            $name[0] = static::$localeDefault;
            $result = static::searchArrayWithNameArray($arr, $name);
        }

        return static::getFromString(is_string($result)?$result:$default, $params);
    }

    /**
     * @param $name
     * @param array $params
     * @param null $default
     * @param bool $getFormDefault
     * @return mixed|null
     */
    public static function getFromFile($name, $params = [], $default = null, $getFormDefault = true)
    {
        $nameArr = static::tryExplodeName($name);

        static::$lang[$nameArr[0]][$nameArr[1]] = static::loadFile($nameArr[0]."/".$nameArr[1].".php");

        return static::getFromArray(static::$lang, $nameArr, $params, $default, $getFormDefault);
    }

    /**
     * @param $string
     * @param array $params
     * @return mixed|null
     */
    public static function getFromString($string, $params = [])
    {
        if ($string === null) {
            return null;
        }

        foreach ($params as $key => $value) {
            $string = str_replace("{" . $key . "}", $value, $string);
        }

        return $string;
    }

    /**
     * @param $name
     * @return array|string
     */
    protected static function tryExplodeName($name)
    {
        if (is_string($name)) {
            $name = static::$locale.".".$name;
            return explode(".", $name);
        }

        return $name;
    }

    /**
     * @param array $arrLang
     * @param array $nameArr
     * @return array|mixed|null
     */
    protected static function searchArrayWithNameArray(array $arrLang, array $nameArr)
    {
        $result = $arrLang;
        for ($i = 0; $i < count($nameArr) && is_array($result); $i++) {
            $result = array_key_exists($nameArr[$i], $result)?$result[$nameArr[$i]]:null;
        }

        return $result;
    }

    /**
     * @param $filename
     * @return array|mixed
     */
    protected static function loadFile($filename)
    {
        $locFile = static::$langDir.$filename;
        return file_exists($locFile)?include($locFile):[];
    }
}
