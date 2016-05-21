<?php
namespace JayaCode\Framework\Core\View;

use JayaCode\Framework\Core\View\Converter\BasicConvert;
use JayaCode\Framework\Core\View\Converter\Converter;
use JayaCode\Framework\Core\View\Template\BasicTemplate;
use JayaCode\Framework\Core\View\Template\Template;
use JayaCode\Framework\Core\View\VariableCollector\BasicVariableCollector;
use JayaCode\Framework\Core\View\VariableCollector\VariableCollector;

/**
 * Class View
 * @property VariableCollector vars
 * @package JayaCode\Framework\Core\View
 */
class View
{
    /**
     * @var VariableCollector
     */
    protected $varCollector;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * View constructor.
     * @param string $viewDir
     * @param $vars
     * @param array $options
     * @throws \Exception
     */
    public function __construct($viewDir = "/", $vars = null, $options = array())
    {

        $this->options = $options + [
            "extension" => ".vj",
            "variableCollectionClass" => BasicVariableCollector::class,
            "templateClass" => BasicTemplate::class,
            "converter" => BasicConvert::class,
            "cacheDir" => null
        ];

        $this->varCollector = new $this->options["variableCollectionClass"]();
        $this->converter = new $this->options["converter"]();

        Template::$extension = $this->options["extension"];

        $this->setViewDir($viewDir);
        if ($vars) {
            $this->varCollector->add($vars);
        }
    }

    /**
     * @param mixed $viewDir
     * @throws \Exception
     */
    public function setViewDir($viewDir)
    {
        if (!is_dir($viewDir)) {
            throw new \Exception("not found directory {$viewDir}");
        }

        $this->options['viewDir'] = rtrim($viewDir, "/") . "/";
    }

    /**
     * @param $name
     * @return VariableCollector|null
     */
    public function __get($name)
    {
        return ($name == "vars")?$this->varCollector:null;
    }

    /**
     * @param $fileTemplate
     * @return Template
     */
    public function template($fileTemplate)
    {
        $fileTemplateReal = str_replace(".", "/", $fileTemplate);
        $fileTemplateReal .= $this->options["extension"];

        return new $this->options["templateClass"]($this->options["viewDir"], $fileTemplateReal,
                                                    $this->varCollector, $this->converter, $this->options['cacheDir']);
    }
}
