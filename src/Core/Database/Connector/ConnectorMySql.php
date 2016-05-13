<?php
namespace JayaCode\Framework\Core\Database\Connector;

/**
 * Class ConnectorMySql
 * @package JayaCode\Framework\Core\Database\Connector
 */
class ConnectorMySql extends Connector
{

    /**
     * @param $config
     * @return string
     */
    public function getDsn($config)
    {
        $host = arr_get($config, "host");
        $port = arr_get($config, "port");
        $dbname = arr_get($config, "dbname");
        $charset = arr_get($config, "charset", "utf8");

        return $port ?
            sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $dbname, $charset):
            sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $dbname, $charset);
    }

    /**
     * @param $config
     * @return \PDO
     */
    public function connect($config)
    {
        return $this->createConnection($this->getDsn($config), $config);
    }
}
