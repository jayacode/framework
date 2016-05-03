<?php
namespace JayaCode\Framework\Core\Controller;

use JayaCode\Framework\Core\Http\Response;
use JayaCode\Framework\Core\View\View;
use Symfony\Component\HttpFoundation\Request;

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
    protected $view;
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

        $this->view = new View();
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
}
