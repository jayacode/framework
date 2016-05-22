<?php
namespace JayaCode\Framework\Tests\Core\Validator;

use JayaCode\Framework\Core\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredRule()
    {
        $validator = Validator\create([
            'name' => 'required'
        ]);

        $this->assertFalse($validator->isValid([]));

        $this->assertEquals([
            "name" => [
                "The name field is required."
            ]
        ], $validator->getErrorMessage());

        $this->assertTrue($validator->isValid(['name' => 'restu']));
    }

    public function testRegexRule()
    {
        $validator = Validator\create([
            'num18' => 'regex:[1-8]'
        ]);

        $this->assertFalse($validator->isValid([
            'num18' => 9
        ]));

        $this->assertEquals([
            "num18" => [
                "num18 (9) is not in the expected format [1-8]."
            ]
        ], $validator->getErrorMessage());

        $this->assertTrue($validator->isValid(['num18' => '1']));
    }

    public function testMultiRule()
    {
        $validator = Validator\create([
            'num13' => 'regex:[1-8]|regex:[1-3]'
        ]);

        $this->assertFalse($validator->isValid([
            'num13' => 9
        ]));

        $this->assertEquals([
            "num13" => [
                "num13 (9) is not in the expected format [1-8].",
                "num13 (9) is not in the expected format [1-3]."
            ]
        ], $validator->getErrorMessage());

        $this->assertTrue($validator->isValid(['num18' => '1']));
    }

    public function testUseAlias()
    {
        $validator = Validator\create([
            'name' => 'required|name:Name Alias'
        ]);

        $this->assertFalse($validator->isValid([]));

        $this->assertEquals([
            "name" => [
                "The Name Alias field is required."
            ]
        ], $validator->getErrorMessage());
    }
}
