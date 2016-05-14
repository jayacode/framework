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
     * @var
     */
    protected $username;

    /**
     * @var
     */
    protected $password;

    /**
     * @var
     */
    protected $options;

    /**
     * Creates a PDO instance representing a connection to a database
     * @param string $dsn
     * @param $config
     * @return PDO
     */
    public function createConnection($dsn, $config)
    {
        $this->username = arr_get($config, "username");
        $this->password = arr_get($config, "password");
        $this->options = arr_get($config, "options", array());

        try {
            return new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (Exception $exception) {
            return $this->tryAgainLostConnection($exception, $dsn);
        }
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
     * @return PDO
     * @throws Exception
     */
    protected function tryAgainLostConnection(Exception $exception, $dsn)
    {

        if ($this->isErrorLostConnection($exception)) {
            return new PDO($dsn, $this->username, $this->password, $this->options);
        } else {
            throw $exception;
        }
    }

    /**
     * @param $config
     * @return string
     */
    abstract protected function getDsn($config);

    /**
     * @param $config
     * @return PDO
     */
    abstract public function connect($config);
}
