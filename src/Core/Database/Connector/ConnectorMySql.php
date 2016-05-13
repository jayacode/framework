<?php
namespace JayaCode\Framework\Core\Database\Connector;

class ConnectorMySql extends Connector
{

    /**
     * @param $options
     * @return string
     */
    public function getDsn($options)
    {
        $host = arr_get($options, "host");
        $dbname = arr_get($options, "dbname");
        $charset = arr_get($options, "charset", "utf8mb4");

        return sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $dbname, $charset);
    }
}
