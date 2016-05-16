<?php
namespace JayaCode\Framework\Tests\Helper\Config;

use JayaCode\Framework\Core\Helper\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        Config::$configDir =__DIR__."/__file";
    }

    /**
     * @dataProvider testGetConfigProvider()
     * @param $expected
     * @param $name
     */
    public function testGetConfig($expected, $name)
    {
        $this->assertEquals($expected, Config::get($name));
        $this->assertEquals($expected, config($name));
    }

    public function testGetConfigProvider()
    {
        return [
            [
                "yee foo bar!",
                "test.foo.bar"
            ],

            [
                "yee foo bar!",
                "test2.foo2.bar2"
            ]
        ];
    }
}
