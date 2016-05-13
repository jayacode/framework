<?php
namespace JayaCode\Framework\Tests\Database\Connector;

use JayaCode\Framework\Core\Database\Connector\ConnectorMySql;

class ConnectorMySqlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDsn()
    {
        $con = new ConnectorMySql();
        $opt = ['host' => 'localhost', 'dbname' => 'foo'];
        $this->assertEquals("mysql:host=localhost;dbname=foo;charset=utf8mb4", $con->getDsn($opt));
    }
}
