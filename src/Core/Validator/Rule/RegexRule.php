<?php
namespace JayaCode\Framework\Core\Validator\Rule;

use JayaCode\Framework\Core\Lang\Lang;

/**
 * Class RegexRule
 * @package JayaCode\Framework\Core\Validator\Rule
 */
class RegexRule extends Rule
{
    /**
     * @var bool
     */
    protected $requireAttribute = true;

    /**
     * @return bool
     */
    public function isValid()
    {
        if ($this->data !== null && !preg_match("/".$this->attributes['arg']."/", $this->data)) {
            $this->setErrorMessage($this->attributes["validatorName"], Lang::get("validator.regex", [
                'format' => $this->attributes['arg'],
                'name' => $this->attributes["name"],
                'value' => $this->data
            ], "{name} ({value}) is not in the expected format {format}."));

            return false;
        }
        return true;
    }
}
