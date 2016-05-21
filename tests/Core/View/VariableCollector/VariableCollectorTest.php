<?php
namespace JayaCode\Framework\Tests\Core\View\VariableCollector;

use JayaCode\Framework\Core\View\VariableCollector\BasicVariableCollector;
use JayaCode\Framework\Core\View\VariableCollector\VariableCollector;

/**
 * Class VariableCollectorTest
 * @package JayaCode\Framework\Tests\Core\View\VariableCollector
 */
class VariableCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VariableCollector;
     */
    protected $dataCollector;

    /**
     *
     */
    public function setUp()
    {
        $this->dataCollector = new BasicVariableCollector([
            "var1" => "valueVar1",
            "var2" => "valueVar2"
        ]);

    }

    /**
     *
     */
    public function testInstanceOfDataCollector()
    {
        $this->assertInstanceOf(VariableCollector::class, $this->dataCollector);
    }

    /**
     *
     */
    public function testAdd()
    {
        $this->dataCollector->add([
            "var2" => "valueVar3"
        ]);

        $this->assertEquals([
            "var1" => "valueVar1",
            "var2" => "valueVar3"
        ], $this->dataCollector->all());
    }

    /**
     *
     */
    public function testReplace()
    {
        $this->dataCollector->replace([
            "var3" => "valueVar3"
        ]);

        $this->assertEquals(["var3" => "valueVar3"], $this->dataCollector->all());
    }

    /**
     *
     */
    public function testGetVar()
    {
        $this->assertNotNull($this->dataCollector->get("var1"));
        $this->assertEquals("valueVar1", $this->dataCollector->get("var1"));
    }
}
