<?php
namespace JayaCode\Framework\Tests\Core\Http;

use JayaCode\Framework\Core\Http\Request;

/**
 * Class RequestTest
 * @package JayaCode\Framework\Tests\Core\Http
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetPath()
    {
        $request = Request::create('', 'GET');
        $this->assertEquals('/', $request->path());

        $request = Request::create('/indonesia/garut/cikajang/', 'GET');
        $this->assertEquals('indonesia/garut/cikajang', $request->path());
    }

    /**
     *
     */
    public function testMethodMethod()
    {
        $request = Request::create('', 'GET');
        $this->assertSame('GET', $request->method());
        $request = Request::create('', 'HEAD');
        $this->assertSame('HEAD', $request->method());
        $request = Request::create('', 'POST');
        $this->assertSame('POST', $request->method());
        $request = Request::create('', 'PUT');
        $this->assertSame('PUT', $request->method());
        $request = Request::create('', 'PATCH');
        $this->assertSame('PATCH', $request->method());
        $request = Request::create('', 'DELETE');
        $this->assertSame('DELETE', $request->method());
        $request = Request::create('', 'OPTIONS');
        $this->assertSame('OPTIONS', $request->method());
    }

    /**
     *
     */
    public function testRootURL()
    {
        $request = Request::create('http://test.com/garut/cikajang');
        $this->assertSame('http://test.com', $request->rootURL());
    }

    /**
     *
     */
    public function testHasRefererURL()
    {
        $request = new Request();

        $this->assertFalse($request->hasRefererURL());

        $request->initialize([], [], [], [], [], ['HTTP_REFERER' => 'http://test.com']);
        $this->assertTrue($request->hasRefererURL());
    }

    /**
     *
     */
    public function testGetRefererURL()
    {
        $request = new Request();

        $this->assertNull($request->refererURL());

        $request->initialize([], [], [], [], [], ['HTTP_REFERER' => 'http://test.com']);
        $this->assertEquals('http://test.com', $request->refererURL());
    }
}
