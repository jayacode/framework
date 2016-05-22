<?php
namespace JayaCode\Framework\Core\Validator\Rule;

/**
 * Class Rule
 * @package JayaCode\Framework\Core\Validator\Rule
 */
abstract class Rule
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $errorMessage = [];
    /**
     * @var null
     */
    protected $data = null;
    /**
     * @var bool
     */
    protected $requireAttribute = false;

    /**
     * Validator constructor.
     */
    public function __construct($rulesString, $defaultName)
    {
        $this->attributes['name'] = $defaultName;
        $this->setRule($rulesString);
    }
    
    /**
     * @param $rulesString
     * @throws \Exception
     */
    public function setRule($rulesString)
    {
        $rulesArr = explode(":", $rulesString);
        $this->attributes['validatorName'] = $rulesArr[0];

        if (isset($rulesArr[1])) {
            $this->setAttribute($rulesArr[1]);
        } elseif ($this->requireAttribute) {
            throw new \Exception("required arg = {$this->attributes['validatorName']}:argument");
        }
    }

    /**
     * @param $stringAttribute
     */
    protected function setAttribute($stringAttribute)
    {
        $this->attributes['arg'] = $stringAttribute;
    }

    /**
     * @return mixed
     */
    abstract public function isValid();

    /**
     * @return array
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param $name
     * @param $message
     */
    protected function setErrorMessage($name, $message)
    {
        $this->errorMessage[$name] = $message;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setAttributes($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
