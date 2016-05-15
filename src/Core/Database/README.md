# JayaCode Database

jayacode database package

## Install

Via Composer

``` bash
$ composer require jayacode/database
```

## Usage
``` php
<?php
use JayaCode\Framework\Core\Database\Database;
use JayaCode\Framework\Core\Database\Query\Grammar\GrammarMySql;

require_once("vendor/autoload.php");

$db = Database::create([
    "grammar" => GrammarMySql::class,

    "host" => "localhost",
    "username" => "root",
    "password" => "",

    "dbname" => "test",
    "options" => []
]);

$db = $db->table("guestbook")->select()->where("name", "restu"); 
// SELECT * FROM `guestbook` WHERE `name` = 'restu'

$db->all();

```

## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
