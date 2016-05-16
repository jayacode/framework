<?php
namespace JayaCode\Framework\Core\Application;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\Route\RouteHandle;
use JayaCode\Framework\Core\Session\Session;

/**
 * Class Application
 * @package JayaCode\Framework\Core\Application
 */
class Application
{
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
     * @var RouteHandle
     */
    public $routeHandle;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Create Application object from static function
     * @return Application
     */
    public static function create()
    {
        return new static();
    }

    /**
     * initialize Application
     */
    public function initialize()
    {
        $this->session = new Session();
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        $this->request = Request::createFromSymfonyGlobal($this->session);

        $this->response = Response::create();
        $this->routeHandle = RouteHandle::create($this->request, $this->response);

        $this->setTimeZone();
    }

    public function setTimeZone($timezone = 'Asia/Jakarta')
    {
        return date_default_timezone_set($timezone);
    }

    /**
     * Run Application
     */
    public function run()
    {
        $this->routeHandle->handle();
        $this->response->send();
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
     * @param array $routesArr
     */
    public function setListRoute($routesArr = array())
    {
        $this->routeHandle->setRoutes($routesArr);
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
