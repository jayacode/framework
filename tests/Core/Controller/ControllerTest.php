<?php
namespace JayaCode\Framework\Tests\Core\Controller;

use JayaCode\Framework\Core\Controller\Controller;
use PHPUnit_Framework_TestCase;

class ControllerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateController()
    {
        $controller = Controller::create();

        $this->assertInstanceOf(Controller::class, $controller);
    }
}
