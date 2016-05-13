<?php
namespace JayaCode\Framework\Core\Database\Connector;

use Exception;
use PDO;
use Stringy\Stringy;

/**
 * Class Connector
 * @package JayaCode\Framework\Core\Database\Connector
 */
class Connector
{

    /**
     * Creates a PDO instance representing a connection to a database
     * @param $dsn
     * @param $username
     * @param $password
     * @param array $options
     * @return PDO
     */
    public function createConnection($dsn, $username, $password, $options = array())
    {
        try {
            $pdo = new PDO($dsn, $username, $password, $options);
        } catch (Exception $e) {
            $pdo = $this->tryAgainCreateConnectionLostConnection($e, $dsn, $username, $password, $options);
        }

        return $pdo;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isErrorLostConnection(Exception $e)
    {
        $message = $e->getMessage();

        $in_str = array(
            'server has gone away',
            'no connection to the server',
            'Lost connection',
            'is dead or not enabled',
            'Error while sending',
            'decryption failed or bad record mac',
            'server closed the connection unexpectedly',
            'SSL connection has been closed unexpectedly',
            'Deadlock found when trying to get lock',
            'Error writing data to the connection',
            'Resource deadlock avoided',
        );

        return Stringy::create($message)->containsAny($in_str, false);
    }

    /**
     * @param Exception $e
     * @param $dsn
     * @param $username
     * @param $password
     * @param $options
     * @return PDO
     */
    protected function tryAgainCreateConnectionLostConnection(Exception $e, $dsn, $username, $password, $options)
    {
        if ($this->isErrorLostConnection($e)) {
            return new PDO($dsn, $username, $password, $options);
        }
    }
}
