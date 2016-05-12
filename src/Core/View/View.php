<?php
namespace JayaCode\Framework\Core\View;

use Twig_Autoloader;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class View
 * @package JayaCode\Framework\Core\View
 */
class View extends Twig_Environment
{

    /**
     * @var array
     */
    private $engineConfig;

    /**
     * @var Twig_Loader_Filesystem
     */
    protected $loader;

    /**
     * View constructor.
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        Twig_Autoloader::register();

        if (!empty($options)) {
            $this->engineConfig = $options;
        } else {
            $this->defaultEngineConfig();
        }

        $this->loader = new Twig_Loader_Filesystem($this->engineConfig['view_dir']);

        parent::__construct($this->loader);

        $this->setCache($this->engineConfig['cache']);
    }

    /**
     *  Init default view engine options
     */
    private function defaultEngineConfig()
    {
        $this->engineConfig['app_dir'] = defined("__APP_DIR__") ? __APP_DIR__ : '/';
        $this->engineConfig['view_dir'] = defined("__APP_DIR__") ? __APP_DIR__.'/resource/views' : '/';

        $this->engineConfig['cache'] = $this->engineConfig['app_dir'].'/tmp/cache/twig';
    }
}
