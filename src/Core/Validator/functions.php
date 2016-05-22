<?php
namespace JayaCode\Framework\Core\Validator;

use JayaCode\Framework\Core\Validator\Dispatcher\BasicValidatorDispatcher;

if (!function_exists('JayaCode\Framework\Core\Validator\create')) {
    /**
     * @param array $rules
     * @param array|null $namespace
     * @return BasicValidatorDispatcher
     */
    function create(array $rules, array $namespace = null)
    {
        return new BasicValidatorDispatcher($rules, $namespace);
    }
}
