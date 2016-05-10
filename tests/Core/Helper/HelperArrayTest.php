<?php
namespace JayaCode\Framework\Tests\Helper\ArrayHelper;

use JayaCode\Framework\Core\Helper\HelperArray;

class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testHasKeyProvider
     * @param $expected
     * @param $arr
     * @param $key
     */
    public function testHasKey($expected, $arr, $key)
    {
        $this->assertEquals($expected, HelperArray::hasKey($arr, $key));
    }

    public function testHasKeyProvider()
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
                false,
                array(
                    "test1" => "test1",
                    "test2" => "test2"
                ),
                "cek"
            ),
            array(
                true,
                array(
                    "test1" => "test1",
                    "test2" => "test2"
                ),
                "test2"
            ),
        );
    }

    /**
     * @dataProvider testGetValProvider
     * @param $expected
     * @param $arr
     * @param $key
     */
    public function testGetVal($expected, $arr, $key)
    {
        $this->assertEquals($expected, HelperArray::getVal($arr, $key));
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
