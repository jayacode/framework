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

    public function testMergeAllArray()
    {
        $arr = array("coba" => "coba");
        $this->assertEquals(["coba" => "coba", "coba2"], ArrayH::arrMergeAll($arr, "coba2"));

        $arr = null;
        $arr = array("coba", "coba2");
        $this->assertEquals(["coba3", "coba2"], arr_merge_all($arr, ["coba3"]));
    }

    public function testArrayExclude()
    {
        $arr = array("coba" => "coba", "coba1" => "coba1", "coba2" => "coba2");
        $this->assertEquals(["coba1" => "coba1"], ArrayH::arrExclude($arr, ["coba", "coba2"]));

        $arr = null;
        $arr = array("coba" => "coba", "coba1" => "coba1", "coba2" => "coba2");
        $this->assertEquals(["coba1" => "coba1"], arr_exclude($arr, ["coba", "coba2"]));
    }
}
