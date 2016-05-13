<?php
namespace JayaCode\Framework\Tests\Helper\AArrayHelper\ArrayHelper;

use JayaCode\Framework\Core\Helper\HelperArray\ArrayH;

class ArrayHTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testGetValProvider
     * @param $expected
     * @param $arr
     * @param $key
     */
    public function testGetVal($expected, $arr, $key)
    {
        $this->assertEquals($expected, ArrayH::get($arr, $key));
        $this->assertEquals($expected, arr_get($arr, $key));
    }

    public function testGetValProvider()
    {
        /**
         * array (
         *  $expected,
         *  $arr
         *  $key
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
        );
    }
}
