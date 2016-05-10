<?php
namespace JayaCode\Framework\Core\Controller;

use JayaCode\Framework\Core\Http\Request;
use JayaCode\Framework\Core\Http\Response;
use Mustache_Autoloader;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use Mustache_Logger_StreamLogger;

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
     * @var Mustache_Engine
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
        $app_dir = defined("__APP_DIR__") ? __APP_DIR__ : '/';
        $view_dir = defined("__APP_DIR__") ? __APP_DIR__.'/resource/views' : '/';

        $this->request = $request;
        $this->response = $response;

        Mustache_Autoloader::register();

        $config_mustache = array(
            'cache' => $app_dir .'/tmp/cache/mustache',
            'cache_file_mode' => 0666, // Please, configure your umask instead of doing this :)
            'cache_lambda_templates' => true,
            'loader' => new Mustache_Loader_FilesystemLoader($view_dir),
            'partials_loader' => new Mustache_Loader_FilesystemLoader($view_dir),
            'helpers' => array('i18n' => function ($text) {
                // do something translatey here...
            }),
            'escape' => function ($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'charset' => 'ISO-8859-1',
            'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
            'strict_callables' => true,
            'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
        );

        $this->view = new Mustache_Engine($config_mustache);
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
