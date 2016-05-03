<?php
namespace JayaCode\Framework\Tests\Core\Http;

use JayaCode\Framework\Core\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testHasRefererURL()
    {
        $request = new Request();

        $this->assertFalse($request->hasRefererURL());

        $request->initialize([], [], [], [], [], ['HTTP_REFERER' => 'http://test.com']);
        $this->assertTrue($request->hasRefererURL());
    }

    public function testGetRefererURL()
    {
        $request = new Request();

        $this->assertNull($request->getRefererURL());

        $request->initialize([], [], [], [], [], ['HTTP_REFERER' => 'http://test.com']);
        $this->assertEquals('http://test.com', $request->getRefererURL());
    }

    /**
     * @dataProvider testGetIpAllProvider
     * @param $expected
     * @param $remoteAddr
     * @param $httpForwardedFor
     * @param $trustedProxies
     */
    public function testGetIp($expected, $remoteAddr, $httpForwardedFor, $trustedProxies)
    {
        $request = $this->getRequestInstanceForIpTests($remoteAddr, $httpForwardedFor, $trustedProxies);

        $this->assertEquals($expected[0], $request->ip());

        Request::setTrustedProxies(array());
    }

    /**
     * @dataProvider testGetIpAllProvider
     * @param $expected
     * @param $remoteAddr
     * @param $httpForwardedFor
     * @param $trustedProxies
     */
    public function testGetIpAll($expected, $remoteAddr, $httpForwardedFor, $trustedProxies)
    {
        $request = $this->getRequestInstanceForIpTests($remoteAddr, $httpForwardedFor, $trustedProxies);

        $this->assertEquals($expected, $request->ipAll());

        Request::setTrustedProxies(array());
    }

    /**
     * @dataProvider testGetIpAllForwardedProvider
     * @param $expected
     * @param $remoteAddr
     * @param $httpForwarded
     * @param $trustedProxies
     */
    public function testGetIpAllForwarded($expected, $remoteAddr, $httpForwarded, $trustedProxies)
    {
        $request = $this->getRequestInstanceForIpAllForwardedTests($remoteAddr, $httpForwarded, $trustedProxies);

        $this->assertEquals($expected, $request->ipAll());

        Request::setTrustedProxies(array());
    }

    public function testGetIpAllForwardedProvider()
    {
        /**
         * array (
         *  $expected,
         *  $remoteAddr,
         *  $httpForwarded,
         *  $trustedProxies
         * )
         */
        return array(

            array(
                array('88.88.88.88'),
                '127.0.0.1',
                'for="88.88.88.88:80"',
                array('127.0.0.1')
            ),

            array(
                array('192.0.2.60'),
                '::1',
                'for=192.0.2.60;proto=http;by=203.0.113.43',
                array('::1')
            ),

            array(
                array('2620:0:1cfe:face:b00c::3', '192.0.2.43'),
                '::1',
                'for=192.0.2.43, for=2620:0:1cfe:face:b00c::3',
                array('::1')
            ),

            array(
                array('2001:db8:cafe::17'),
                '::1',
                'for="[2001:db8:cafe::17]:4711',
                array('::1')
            ),
        );
    }

    public function testGetIpAllProvider()
    {
        /**
         * array (
         *  $expected,
         *  $remoteAddr,
         *  $httpForwarded,
         *  $trustedProxies
         * )
         */
        return array(
            // simple IPv4
            array(
                array('88.88.88.88'),
                '88.88.88.88',
                null,
                null
            ),

            // trust the IPv4 remote addr
            array(
                array('88.88.88.88'),
                '88.88.88.88',
                null,
                array('88.88.88.88')
            ),

            // simple IPv6
            array(
                array('::1'),
                '::1',
                null,
                null
            ),

            // trust the IPv6 remote addr
            array(
                array('::1'),
                '::1',
                null,
                array('::1')
            ),

            // forwarded for with remote IPv4 addr not trusted
            array(
                array('127.0.0.1'),
                '127.0.0.1',
                '88.88.88.88',
                null
            ),

            // forwarded for with remote IPv4 addr trusted
            array(
                array('88.88.88.88'),
                '127.0.0.1',
                '88.88.88.88',
                array('127.0.0.1')
            ),

            // forwarded for with remote IPv4 and all FF addrs trusted
            array(
                array('88.88.88.88'),
                '127.0.0.1',
                '88.88.88.88',
                array('127.0.0.1', '88.88.88.88')
            ),

            // forwarded for with remote IPv4 range trusted
            array(
                array('88.88.88.88'),
                '123.45.67.89',
                '88.88.88.88',
                array('123.45.67.0/24')
            ),

            // forwarded for with remote IPv6 addr not trusted
            array(
                array('1620:0:1cfe:face:b00c::3'),
                '1620:0:1cfe:face:b00c::3',
                '2620:0:1cfe:face:b00c::3',
                null
            ),

            // forwarded for with remote IPv6 addr trusted
            array(
                array('2620:0:1cfe:face:b00c::3'),
                '1620:0:1cfe:face:b00c::3',
                '2620:0:1cfe:face:b00c::3',
                array('1620:0:1cfe:face:b00c::3')
            ),

            // forwarded for with remote IPv6 range trusted
            array(
                array('88.88.88.88'),
                '2a01:198:603:0:396e:4789:8e99:890f',
                '88.88.88.88',
                array('2a01:198:603:0::/65')
            ),

            // multiple forwarded for with remote IPv4 addr trusted
            array(
                array('88.88.88.88', '87.65.43.21', '127.0.0.1'),
                '123.45.67.89',
                '127.0.0.1, 87.65.43.21, 88.88.88.88',
                array('123.45.67.89')
            ),

            // multiple forwarded for with remote IPv4 addr and some reverse proxies trusted
            array(
                array('87.65.43.21', '127.0.0.1'),
                '123.45.67.89',
                '127.0.0.1, 87.65.43.21, 88.88.88.88',
                array('123.45.67.89', '88.88.88.88')
            ),

            // multiple forwarded for with remote IPv4 addr and some reverse proxies trusted but in the middle
            array(
                array('88.88.88.88', '127.0.0.1'),
                '123.45.67.89', '127.0.0.1, 87.65.43.21, 88.88.88.88',
                array('123.45.67.89', '87.65.43.21')
            ),

            // multiple forwarded for with remote IPv4 addr and all reverse proxies trusted
            array(
                array('127.0.0.1'),
                '123.45.67.89',
                '127.0.0.1, 87.65.43.21, 88.88.88.88',
                array('123.45.67.89', '87.65.43.21', '88.88.88.88', '127.0.0.1')
            ),

            // multiple forwarded for with remote IPv6 addr trusted
            array(
                array('2620:0:1cfe:face:b00c::3', '3620:0:1cfe:face:b00c::3'),
                '1620:0:1cfe:face:b00c::3',
                '3620:0:1cfe:face:b00c::3,2620:0:1cfe:face:b00c::3',
                array('1620:0:1cfe:face:b00c::3')
            ),

            // multiple forwarded for with remote IPv6 addr and some reverse proxies trusted
            array(
                array('3620:0:1cfe:face:b00c::3'),
                '1620:0:1cfe:face:b00c::3',
                '3620:0:1cfe:face:b00c::3,2620:0:1cfe:face:b00c::3',
                array('1620:0:1cfe:face:b00c::3', '2620:0:1cfe:face:b00c::3')
            ),

            // multiple forwarded for with remote IPv4 addr and some reverse proxies trusted but in the middle
            array(
                array('2620:0:1cfe:face:b00c::3', '4620:0:1cfe:face:b00c::3'),
                '1620:0:1cfe:face:b00c::3',
                '4620:0:1cfe:face:b00c::3,3620:0:1cfe:face:b00c::3,2620:0:1cfe:face:b00c::3',
                array('1620:0:1cfe:face:b00c::3', '3620:0:1cfe:face:b00c::3')
            ),

            // client IP with port
            array(
                array('88.88.88.88'),
                '127.0.0.1',
                '88.88.88.88:12345, 127.0.0.1',
                array('127.0.0.1')
            ),
        );
    }

    private function getRequestInstanceForIpTests($remoteAddr, $httpForwardedFor, $trustedProxies)
    {
        $request = new Request();

        $server = array('REMOTE_ADDR' => $remoteAddr);
        if (null !== $httpForwardedFor) {
            $server['HTTP_X_FORWARDED_FOR'] = $httpForwardedFor;
        }

        if ($trustedProxies) {
            Request::setTrustedProxies($trustedProxies);
        }

        $request->initialize(array(), array(), array(), array(), array(), $server);

        return $request;
    }

    private function getRequestInstanceForIpAllForwardedTests($remoteAddr, $httpForwarded, $trustedProxies)
    {
        $request = new Request();

        $server = array('REMOTE_ADDR' => $remoteAddr);

        if (null !== $httpForwarded) {
            $server['HTTP_FORWARDED'] = $httpForwarded;
        }

        if ($trustedProxies) {
            Request::setTrustedProxies($trustedProxies);
        }

        $request->initialize(array(), array(), array(), array(), array(), $server);

        return $request;
    }
}
