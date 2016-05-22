<?php
namespace JayaCode\Framework\Core\Validator\Dispatcher;

/**
 * Class ValidatorDispatcher
 * @package JayaCode\Framework\Core\Validator\Dispatcher
 */
abstract class ValidatorDispatcher
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $errorMessage = [];
    /**
     * @var array
     */
    protected $namespaceClassRule = [
            'App\\Validator\\Rule\\',
            'JayaCode\\Framework\\Core\\Validator\\Rule\\'
    ];

    /**
     * ValidatorDispatcher constructor.
     * @param array $rules
     * @param array $namespace
     */
    public function __construct(array $rules, array $namespace = null)
    {
        $this->initRule($rules);

        if (is_array($namespace)) {
            foreach ($this->namespaceClassRule as $item) {
                array_push($namespace, $item);
            }

            $this->namespaceClassRule = $namespace;
        }
    }


    /**
     * @param array $data
     * @return mixed
     */
    abstract public function isValid($data = []);

    /**
     * @return array
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param array $rules
     */
    abstract public function initRule(array $rules);

    /**
     * @param $attributesString
     * @param $nameData
     * @return mixed
     */
    abstract protected function getObjectRule($attributesString, $nameData);
}
