<?php
namespace JayaCode\Framework\Core\View\Template;

use JayaCode\Framework\Core\View\Converter\Converter;
use JayaCode\Framework\Core\View\VariableCollector\VariableCollector;

/**
 * Class Template
 * @property VariableCollector vars
 * @package JayaCode\Framework\Core\View\Template
 */
abstract class Template
{
    /**
     * @var
     */
    public static $extension;

    /**
     * @var string
     */
    protected $locTemplate;
    /**
     * @var string
     */
    protected $fileTemplate;

    /**
     * @var string|null
     */
    protected $script = null;

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * @var
     */
    protected $locView;
    /**
     * @var null|string
     */
    protected $cacheDir;

    /**
     * @var VariableCollector
     */
    protected $variableCollector;

    /**
     * Template constructor.
     * @param $locView
     * @param $fileTemplate
     * @param VariableCollector $variableCollector
     * @param Converter $converter
     * @param null $cacheDir
     * @throws \Exception
     */
    public function __construct(
        $locView,
        $fileTemplate,
        VariableCollector $variableCollector,
        Converter $converter,
        $cacheDir = null
    ) {
        $this->variableCollector = $variableCollector;

        $this->locView = $locView;
        $this->fileTemplate = $fileTemplate;
        $this->locTemplate = $this->locView.$fileTemplate;
        $this->converter = $converter;
        $this->cacheDir = $cacheDir?rtrim($cacheDir, "/")."/":null;

        if (!file_exists($this->locTemplate)) {
            throw new \Exception("not found file or directory {$fileTemplate}");
        }

        if (!is_readable($this->locTemplate)) {
            throw new \Exception("Template not readable: $this->locTemplate", 4);
        }
    }

    /**
     * @return mixed
     */
    abstract public function render();

    /**
     * @param $name
     * @return VariableCollector|null
     */
    public function __get($name)
    {
        return $name == "vars"?$this->variableCollector:null;
    }

    /**
     * @return mixed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param mixed $script
     */
    public function setScript($script)
    {
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function getLocTemplates()
    {
        return $this->locTemplate;
    }

    /**
     * @param string $locTemplate
     */
    public function setLocTemplate($locTemplate)
    {
        $this->locTemplate = $locTemplate;
    }
}
