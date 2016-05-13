<?php
namespace JayaCode\Framework\Tests\Helper\HelperArray;

use JayaCode\Framework\Core\Helper\HelperArray\ArrayH;

class ArrayHTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testGetValProvider
     * @param $expected
     * @param $arr
     * @param $key
     * @param null $default
     */
    public function testGetVal($expected, $arr, $key, $default = null)
    {
        $this->assertEquals($expected, ArrayH::get($arr, $key, $default));
        $this->assertEquals($expected, arr_get($arr, $key, $default));
    }

    public function testGetValProvider()
    {
        /**
         * array (
         *  $expected,
         *  $arr
         *  $key
         *  $default
         * )
         */
        return array(
            array(
                "test1val",
                array(
                    "test1" => "test1val",
                    "test2" => "test1val"
                ),
                "test1"
            ),
            array(
                "test1-1-1-val",
                array(
                    "test1" => array(
                        "test1-1" => array(
                            "test1-1-1" => "test1-1-1-val"
                        )
                    ),
                    "test2" => "test2"
                ),
                "test1.test1-1.test1-1-1"
            ),

            array(
                array(
                    "test1-1-1" => "test1-1-1-val"
                ),
                array(
                    "test1" => array(
                        "test1-1" => array(
                            "test1-1-1" => "test1-1-1-val"
                        )
                    ),
                    "test2" => "test2"
                ),
                "test1.test1-1"
            ),

            array(
                "default-value",
                array(
                    "test1" => array(
                        "test1-1" => array(
                            "test1-1-1" => "test1-1-1-val"
                        )
                    ),
                    "test2" => "test2"
                ),
                "test1.test7-1",
                "default-value"
            ),
        );
    }
}
