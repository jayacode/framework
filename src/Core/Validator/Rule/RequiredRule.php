<?php
namespace JayaCode\Framework\Core\Validator\Rule;

use JayaCode\Framework\Core\Lang\Lang;

/**
 * Class RequiredRule
 * @package JayaCode\Framework\Core\Validator\Rule
 */
class RequiredRule extends Rule
{

    /**
     * @return bool
     */
    public function isValid()
    {
        if ($this->data === null || empty($this->data)) {
            $this->setErrorMessage($this->attributes["validatorName"], Lang::get("validator.required", [
                'name' => $this->attributes["name"]
            ], "The {name} field is required."));

            return false;
        }

        return true;
    }
}
