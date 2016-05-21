<?php
namespace JayaCode\Framework\Core\View\Template;

/**
 * Class BasicTemplate
 * @package JayaCode\Framework\Core\View\Template
 */
class BasicTemplate extends Template
{
    /**
     * @var
     */
    protected $parent;

    /**
     * @return string
     */
    public function buildScript()
    {
        $fileCache = $this->cacheDir.str_replace(["/", "."], "_", $this->fileTemplate);
        if ($this->cacheDir && file_exists($fileCache) && empty($this->contentParent)) {
            return $this->script = file_get_contents($fileCache);
        }

        $this->script = $this->converter->build(file_get_contents($this->locTemplate));
        
        if ($this->cacheDir && empty($this->contentParent)) {
            file_put_contents($fileCache, $this->script);
        }
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        if (!$this->script) {
            $this->buildScript();
        }

        extract($this->vars->all());
        ob_start();
        eval("?>" . $this->script);
        $result = ob_get_contents();
        ob_end_clean();
        
        if ($this->parent) {
            $fileParent = $this->parent.Template::$extension;
            $parent = new BasicTemplate($this->locView, $fileParent, $this->variableCollector, $this->converter);
            $parent->setContentParent($this->contentParent);
            return $parent->render();
        }
        return $result;
    }

    /**
     * @param $name
     */
    public function setParent($name)
    {
        $this->parent = $name;
    }

    /**
     * @var array
     */
    protected $contentParent = [];

    /**
     * @return array
     */
    public function getContentParent()
    {
        return $this->contentParent;
    }

    /**
     * @param array $contentParent
     */
    public function setContentParent($contentParent)
    {
        $this->contentParent = $contentParent;
    }
}
