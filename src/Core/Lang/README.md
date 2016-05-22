# JayaCode i18n

jayacode i18n package

## Requirements
* PHP >= 5.5

## Usage

``` php
// path/lang/eng/message.php
<?php
return [
    'bar' => 'bar',
    'welcome' => 'welcome {name}',
    'foo' => [
        'subfoo' => "subfoo"
    ]
];

```

``` php
// path/lang/id/message.php
<?php
return [
    'bar' => 'bar',
    'welcome' => 'selamat datang {name}',
    'foo' => [
        'subfoo' => "dalamfoo"
    ]
];

```

get i18n
```php
Lang::setDir("path/lang");

echo Lang::get('message.welcome', ['name' => 'JayaCode']);
//out : 'welcome JayaCode'

Lang::setLocale('id');
echo Lang::get('message.welcome', ['name' => 'JayaCode']);
//out : 'selamat datang JayaCode'

Lang::setLocale('sunda');
echo Lang::get('message.welcome', ['name' => 'JayaCode']);
//out : 'welcome JayaCode'

echo Lang::get('message.nothing', ['name' => 'JayaCode'], "not found");
//out : 'not found'
```

### Get From String
``` php
echo Lang::getFromString("nama saya {name}", ['name' => 'JayaCode']);
// out : nama saya JayaCode
```

### Get From Array
``` php
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

echo Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode']);
//out : 'welcome JayaCode'

Lang::setLocale('id');
echo Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode']);
//out : 'selamat datang JayaCode'

Lang::setLocale('sunda');
echo Lang::getFromArray($lang, 'message.welcome', ['name' => 'JayaCode']);
//out : 'welcome JayaCode'

echo Lang::getFromArray($lang, 'message.nothing', ['name' => 'JayaCode'], "not found");
//out : 'not found'
```


## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
