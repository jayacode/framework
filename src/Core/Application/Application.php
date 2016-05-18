<?php
namespace JayaCode\Framework\Core\Application;

use JayaCode\Framework\Core\Database\Database;
use JayaCode\Framework\Core\Database\Model\Model;
use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\Route\Dispatcher\Dispatcher as DispatcherRoute;
use JayaCode\Framework\Core\Route\Status;
use JayaCode\Framework\Core\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

/**
 * Class Application
 * @package JayaCode\Framework\Core\Application
 */
class Application
{
    /**
     * @var Application
     */
    public static $app;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Session
     */
    public $session;

    /**
     * @var DispatcherRoute
     */
    protected $routeDispatcher;

    /**
     * @var Database
     */
    public $db;

    /**
     * Application constructor.
     * @param SessionStorageInterface $storage
     */
    public function __construct(SessionStorageInterface $storage = null)
    {
        $this->initialize($storage);
    }

    /**
     * Create Application object from static function
     * @param SessionStorageInterface $storage
     * @return Application
     */
    public static function create(SessionStorageInterface $storage = null)
    {
        return new static($storage);
    }

    /**
     * initialize Application
     * @param SessionStorageInterface $storage
     */
    public function initialize(SessionStorageInterface $storage = null)
    {
        $this->session = new Session($storage);
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        $this->request = Request::createFromSymfonyGlobal($this->session);

        $this->response = Response::create();

        static::$app = $this;

        $this->setTimeZone();

        $this->initDatabase();
    }

    /**
     * initialize Database
     */
    protected function initDatabase()
    {
        $dbConfig = (array) config("database");

        if (count($dbConfig) > 0) {
            $this->db = new Database($dbConfig);
            Model::$db = $this->db;
        }
    }

    /**
     * @param string $timezone
     * @return bool
     */
    public function setTimeZone($timezone = 'Asia/Jakarta')
    {
        return date_default_timezone_set($timezone);
    }

    /**
     * @param $baseDir
     */
    public function initConfigDir($baseDir)
    {
        if (!defined("__APP_DIR__")) {
            define("__APP_DIR__", $baseDir);
        }

        if (!defined("__CONFIG_DIR__")) {
            define("__CONFIG_DIR__", __APP_DIR__."/config");
        }
    }

    /**
     * Run Application
     */
    public function run()
    {
        $route = $this->routeDispatcher->dispatch($this->request->method(), $this->request->path());

        if ($route[0] == Status::FOUND) {
            if (is_callable($route[1])) {
                $this->response->setContent(call_user_func($route[1]));
            } elseif (is_array($route[1])) {
                $controllerName = $route[1]["controller"];
                $actionMethod = $route[1]["method"];

                $controller = new $controllerName($this);

                $content = $controller->$actionMethod($this->request);
                $this->response->setDataContent($content);
            }
        } else {
            $this->response->setNotFound();
        }

        $this->response->send();

        $this->terminate();
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param callable $definitionCollection
     */
    public function setDataRoute($definitionCollection)
    {
        $this->routeDispatcher = \JayaCode\Framework\Core\Route\dispatcherBasic($definitionCollection);
    }

    /**
     * terminate application
     */
    public function terminate()
    {
        $inputs = array(
            "post" => $this->request->post(),
            "query" => $this->request->query()
        );
        $this->session->setFlash("old", $inputs);

        $this->request->getSession()->terminate();
    }
}
