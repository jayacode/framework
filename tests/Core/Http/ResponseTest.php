<?php
namespace JayaCode\Framework\Tests\Core\Http;

use JayaCode\Framework\Core\Http\Response;
use PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testResponseContentProvider
     * @param $expected
     * @param $content
     */
    public function testResponseContent($expected, $content)
    {
        $response = Response::create($content);

        $this->assertEquals($expected, $response->getContent());
    }

    public function testResponseContentProvider()
    {
        /**
         * array (
         *  $expected,
         *  $content
         * )
         */
        return [
            [
                'string',
                'string'
            ],
            [
                '["string"]',
                ['string']
            ]
        ];
    }
}
