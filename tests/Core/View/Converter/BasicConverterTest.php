<?php
namespace JayaCode\Framework\Tests\Core\View\Converter;

use JayaCode\Framework\Core\View\Converter\BasicConvert;
use JayaCode\Framework\Core\View\Converter\Converter;

class BasicConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Converter
     */
    protected $converter;
    
    public function setUp()
    {
        $this->converter = new BasicConvert();
    }


    /**
     * @dataProvider convertStringDataProvider()
     * @param $expected
     * @param $string
     */
    public function testCovertString($expected, $string)
    {
        $this->assertEquals($expected, $this->converter->build($string));
    }

    public function convertStringDataProvider()
    {
        return [
            [
                "<?php if(true): ?>",
                "@if(true):"
            ],

            [
                "foo
                    <?php echo(htmlspecialchars(\$foo)); ?>
                foo",
                "foo
                    {{\$foo}}
                foo"
            ],

            [
                "foo
                    <?php 
                        if (true) {
                            // doo doo doo
                        }
                     ?>
                foo",
                "foo
                    [[
                        if (true) {
                            // doo doo doo
                        }
                    ]]
                foo"
            ],

            [
                "<?php \$this->setParent('master'); ?>",
                "[@ parent master @]"
            ],
        ];
    }
}
