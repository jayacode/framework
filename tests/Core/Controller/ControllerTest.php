<?php
namespace JayaCode\Framework\Tests\Core\Controller;

use JayaCode\Framework\Core\Application\Application;
use JayaCode\Framework\Core\Controller\Controller;
use JayaCode\Framework\Core\Http\Response;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Application
     */
    protected $app;
    /**
     * @var Controller
     */
    protected $controller;

    protected function setUp()
    {
        $this->app = new Application(new MockArraySessionStorage());

        $this->controller = Controller::create($this->app);
    }

    public function testCreateController()
    {
        $this->assertInstanceOf(Controller::class, $this->controller);
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf(Response::class, $this->controller->getResponse());
    }
}
