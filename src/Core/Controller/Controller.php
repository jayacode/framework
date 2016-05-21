<?php
namespace JayaCode\Framework\Core\Controller;

use JayaCode\Framework\Core\Application\Application;
use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\Session\Session;
use JayaCode\Framework\Core\View\View;

/**
 * Class Controller
 * @package JayaCode\Framework\Core\Controller
 */
class Controller
{
    /**
     * @var Application
     */
    protected $app;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var View
     */
    protected $viewEngine;

    /**
     * Controller constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->initialize($app);
    }

    /**
     * @param Application $app
     */
    public function initialize(Application $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->response = $app->response;
        $this->session = $app->session;

        $this->viewEngine = new View(config("app.viewDir", __DIR__));
        $this->viewEngine->vars->add([
            "app" => $this->app,
            "request" => $this->request,
            "response" => $this->response,
            "session" => $this->session
        ]);
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function out(Response $response)
    {
        return $response->send();
    }

    /**
     * @param Application $app
     * @return Controller
     */
    public static function create(Application $app)
    {
        return new static($app);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Render Template View
     * @param $name
     * @param array $data
     * @return string
     */
    protected function view($name, array $data = array())
    {
        $tpl = $this->viewEngine->template($name);
        $tpl->vars->add($data);

        return $tpl->render();
    }
}
