<?php
namespace JayaCode\Framework\Tests\Core\Application;

use JayaCode\Framework\Core\Application\Application;
use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use PHPUnit_Framework_TestCase;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testCreateApp()
    {
        $app = Application::create();

        $this->assertInstanceOf(Application::class, $app);
    }

    public function testGetRequest()
    {
        $app = Application::create();
        $this->assertInstanceOf(Application::class, $app);

        $this->assertInstanceOf(Request::class, $app->getRequest());
    }

    public function testGetResponse()
    {
        $app = Application::create();
        $this->assertInstanceOf(Application::class, $app);

        $this->assertInstanceOf(Response::class, $app->getResponse());
    }
}
