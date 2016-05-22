<?php
namespace JayaCode\Framework\Core\Validator\Dispatcher;

use JayaCode\Framework\Core\Validator\Rule\Rule;

/**
 * Class BasicValidatorDispatcher
 * @package JayaCode\Framework\Core\Validator\Dispatcher
 */
class BasicValidatorDispatcher extends ValidatorDispatcher
{

    /**
     * @param array $data
     * @return bool
     */
    public function isValid($data = [])
    {
        $this->errorMessage = [];

        $isValid = true;
        foreach ($this->rules as $nameData => $rules) {
            foreach ($rules as $rule) {
                /** @var Rule $rule */
                $rule->setData(arr_get($data, $nameData));
                if (!$rule->isValid()) {
                    foreach ($rule->getErrorMessage() as $message) {
                        if (!isset($this->errorMessage[$nameData])) {
                            $this->errorMessage[$nameData] = [];
                        }
                        array_push($this->errorMessage[$nameData], $message);
                    }

                    $isValid = $isValid?false:$isValid;
                }
            }
        }

        return $isValid;
    }

    /**
     * @param array $rules
     */
    public function initRule(array $rules)
    {
        foreach ($rules as $nameData => $attributeRule) {
            $name = $nameData;
            if (preg_match('/\|?name\:(\w+[\s\w+]*)\|?/', $attributeRule, $match)) {
                $name = $match[1];
            }
            $attributeRuleArr = explode("|", $attributeRule);

            foreach ($attributeRuleArr as $item) {
                if (!preg_match('/name.*/', $item)) {
                    $this->rules[$nameData][] = $this->getObjectRule($item, $name);
                }
            }
        }
    }

    /**
     * @param $name
     * @return string
     * @throws \Exception
     */
    protected function getClassRule($name)
    {
        $className = ucwords($name).'Rule';

        foreach ($this->namespaceClassRule as $namespace) {
            if (class_exists($namespace.$className)) {
                return $namespace.$className;
            }
        }

        throw new \Exception("class {$className} not found");
    }

    /**
     * @param $attributeRule
     * @param $nameData
     * @return mixed
     * @throws \Exception
     */
    protected function getObjectRule($attributeRule, $nameData)
    {
        $rulesArr = explode(":", $attributeRule);
        $class = $this->getClassRule($rulesArr[0]);

        return new $class($attributeRule, $nameData);
    }
}
