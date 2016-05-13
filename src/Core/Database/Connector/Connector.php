<?php
namespace JayaCode\Framework\Core\Database\Connector;

use Exception;
use PDO;
use Stringy\Stringy;

/**
 * Class Connector
 * @package JayaCode\Framework\Core\Database\Connector
 */
abstract class Connector
{
    /**
     * @var PDO
     */
    protected $pdo;

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
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (Exception $exception) {
            $this->pdo = $this->tryAgainLostConnection($exception, $dsn, $username, $password, $options);
        }

        return $this->pdo;
    }

    /**
     * @param Exception $exception
     * @return bool
     */
    protected function isErrorLostConnection(Exception $exception)
    {
        $message = $exception->getMessage();

        $inStr = array(
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

        return Stringy::create($message)->containsAny($inStr, false);
    }

    /**
     * @param Exception $exception
     * @param $dsn
     * @param $username
     * @param $password
     * @param $options
     * @return PDO
     */
    protected function tryAgainLostConnection(
        Exception $exception,
        $dsn,
        $username,
        $password,
        $options
    ) {
        if ($this->isErrorLostConnection($exception)) {
            return new PDO($dsn, $username, $password, $options);
        }
    }

    /**
     * @param $options
     * @return string
     */
    abstract protected function getDsn($options);
}
