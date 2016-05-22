# JayaCode Validator

jayacode validator package

## Requirements
* PHP >= 5.5

## Usage
``` php
<?php
use JayaCode\Framework\Core\Validator;

require_once "vendor/autoload.php";

$validator = Validator\create([
    'id'   => 'required|regex:/[\d]+/',
    'firstName' => 'required|name:First Name'
]);

if (!$validator->isValid(['name' => 'restu'])) {
    var_dump($validator->getErrorMessage());
}
```

### Default Rules
```php
'required'
```
The field under validation must be present in the input data and not empty. 


```php
'regex:pattern'
```
The field under validation must match the given regular expression.

### Create Custom Rule

```php
// MyValidatorRule.php
namespace My\App\Validator\Rule;

use JayaCode\Framework\Core\Validator\Rule;

class MyValidatorRule extends Rule
{
    public function isValid()
    {
        if ($this->data != 'my rule') {
            $this->setErrorMessage("myRule", "invalid input");
            return false;
        }
        return true;
    }
}

```

```php
// index.php
use JayaCode\Framework\Core\Validator;

require_once "vendor/autoload.php";

$validator = Validator\create([
    'field' => 'myValidator'
], [
    'My\\App\\Validator\\Rule\\'
);

// if namespace MyValidatorRule == App\Validator\Rule
// $validator = Validator\create(['field' => 'myValidator']);

if (!$validator->isValid($dataArr)) {
    var_dump($validator->getErrorMessage());
}
```

## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
