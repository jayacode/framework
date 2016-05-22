<?php
namespace JayaCode\Framework\Core\Helper\Config;

/**
 * Class Config
 * @package JayaCode\Framework\Core\Config
 */
class Config
{
    /**
     * @var string
     */
    public static $configDir = null;
    /**
     * @var array
     */
    protected static $dataConfig = array();

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        $configName = explode(".", $name);
        $configName = $configName[0];

        if (!isset(static::$dataConfig[$configName])) {
            static::$dataConfig[$configName] = static::load($configName.".php");
        }

        if ($configName == $name && !is_array(static::$dataConfig[$configName])) {
            return static::$dataConfig[$configName];
        }

        return arr_get(static::$dataConfig, $name, $default);
    }

    /**
     * @param $filename
     * @return array|mixed
     */
    public static function load($filename)
    {
        if (is_null(static::$configDir)) {
            static::initConfigDir();
        }

        $locFile = static::$configDir."/".$filename;
        return file_exists($locFile)?include($locFile):array();
    }

    /**
     * Init $configDir
     */
    protected static function initConfigDir()
    {
        static::$configDir = defined("__CONFIG_DIR__")?__CONFIG_DIR__:__DIR__."/config";
    }
}
