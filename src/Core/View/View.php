<?php
namespace JayaCode\Framework\Core\View;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use Mustache_Logger_StreamLogger;

/**
 * Class View
 * @package JayaCode\Framework\Core\View
 */
class View extends Mustache_Engine
{
    private $app_dir;
    private $view_dir;

    private $engineConfig;

    /**
     * View constructor.
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->app_dir = defined("__APP_DIR__") ? __APP_DIR__ : '/';
        $this->view_dir = defined("__APP_DIR__") ? __APP_DIR__.'/resource/views' : '/';

        if (!empty($options)) {
            $this->engineConfig = $options;
        } else {
            $this->defaultEngineConfig();
        }

        parent::__construct($this->engineConfig);
    }

    /**
     *  Init default view engine options
     */
    private function defaultEngineConfig()
    {
        $this->engineConfig = array(
            'cache' => $this->app_dir .'/tmp/cache/mustache',
            'cache_file_mode' => 0666, // Please, configure your umask instead of doing this :)
            'cache_lambda_templates' => true,
            'loader' => new Mustache_Loader_FilesystemLoader($this->view_dir),
            'partials_loader' => new Mustache_Loader_FilesystemLoader($this->view_dir),
            'escape' => function ($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'charset' => 'ISO-8859-1',
            'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
            'strict_callables' => true,
            'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
        );
    }
}
