<?php
namespace JayaCode\Framework\Tests\Core\View;

use JayaCode\Framework\Core\View\VariableCollector\VariableCollector;
use JayaCode\Framework\Core\View\View;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var View
     */
    protected $view;

    public function setUp()
    {
        $this->view = new View(__DIR__."/__file_view_test");
    }

    public function testSetVar()
    {
        $this->assertInstanceOf(VariableCollector::class, $this->view->vars);

        $this->view->vars->add([
            "var" => "var1"
        ]);

        $this->assertEquals("var1", $this->view->vars->get("var"));
    }
    
    public function testView()
    {
        $this->view->vars->add([
            "var" => "var1"
        ]);

        $template = $this->view->template("test.test");

        $this->assertEquals("test  

var1var1var1
 coba", $template->render());
    }
}
