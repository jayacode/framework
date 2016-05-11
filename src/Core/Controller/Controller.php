<?php
namespace JayaCode\Framework\Core\Controller;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\View\View;

/**
 * Class Controller
 * @package JayaCode\Framework\Core\Controller
 */
class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var View
     */
    protected $viewEngine;
    /**
     * Controller constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request = null, Response $response = null)
    {
        $this->initialize($request, $response);
    }

    /**
     * @param Request|null $request
     * @param Response $response
     */
    public function initialize(Request $request = null, Response $response = null)
    {
        $this->request = $request;
        $this->response = $response;

        $this->viewEngine = new View();
    }

    /**
     * @param Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function out(Response $response)
    {
        return $response->send();
    }

    /**
     * @param Request|null $request
     * @param Response|null $response
     * @return Controller
     */
    public static function create(Request $request = null, Response $response = null)
    {
        return new static($request, $response);
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
    public function view($name, array $data = array())
    {
        $tpl = $this->viewEngine->loadTemplate($name);
        return $tpl->render($data);
    }
}
