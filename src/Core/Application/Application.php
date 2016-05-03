<?php
namespace JayaCode\Framework\Core\Application;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\Router\Router;

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
     * @var Router
     */
    public $router;

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
        return new Application();
    }

    /**
     * initialize Application
     */
    public function initialize()
    {
        $this->request = Request::createFromGlobals();
        $this->response = Response::create();
        $this->router = Router::create($this->request, $this->response);

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
        $this->router->handle();
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
}
