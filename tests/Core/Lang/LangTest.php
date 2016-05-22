<?php
namespace JayaCode\Framework\Core\Lang;

class LangTest extends \PHPUnit_Framework_TestCase
{
    public function testLangFromString()
    {
        $result = Lang::getFromString("nama saya {name}", ['name' => 'JayaCode']);

        $this->assertEquals("nama saya JayaCode", $result);

        $result = Lang::getFromString("saya {name}, saya asli {nation}", [
            'name' => 'JayaCode',
            'nation' => 'Indonesia']);

        $this->assertEquals("saya JayaCode, saya asli Indonesia", $result);
    }

    public function testLangFromArray()
    {
        Lang::setLocale('eng');

        $lang = [
            'id' => [
                'message' => [
                    'bar' => 'bar',
                    'welcome' => 'selamat datang {name}',
                    'foo' => 'foo'
                ]
            ],
            'eng' => [
                'message' => [
                    'bar' => 'bar',
                    'welcome' => 'welcome {name}',
                    'foo' => 'foo'
                ]
            ]
        ];

        $this->assertEquals('welcome JayaCode', Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode']));
        
        Lang::setLocale('id');
        $this->assertEquals(
            'selamat datang JayaCode',
            Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode'])
        );

        Lang::setLocale('sunda');
        $this->assertEquals('welcome JayaCode', Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode']));
        
        $this->assertEquals(
            'not found',
            Lang::getFromArray($lang, 'message.nothing', ['name' => 'JayaCode'], "not found")
        );
    }

    public function testGetLangFromFile()
    {
        Lang::setDir(__DIR__."/_lang_file");

        Lang::setLocale('eng');
        $this->assertEquals('welcome JayaCode', Lang::get('message.welcome', ['name' => 'JayaCode']));

        Lang::setLocale('id');
        $this->assertEquals(
            'selamat datang JayaCode',
            Lang::get('message.welcome', ['name' => 'JayaCode'])
        );

        Lang::setLocale('sunda');
        $this->assertEquals('welcome JayaCode', Lang::get('message.welcome', ['name' => 'JayaCode']));

        $this->assertEquals('not found', Lang::get('message.nothing', ['name' => 'JayaCode'], "not found"));
    }
}
