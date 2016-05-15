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

require_once("vendor/autoload.php");

$db = Database::create([
    "driver" => "mysql",

    "host" => "localhost",
    "username" => "root",
    "password" => "",

    "dbname" => "test",
    "options" => []
]);

$db = $db->table("guestbook")->select()->where("name", "restu"); 
// SELECT * FROM `guestbook` WHERE `name` = 'restu'

/**
 * get all data
 */

$db->execute()->all();

// OR

$db->execute();
while ($data = $db->get()) {
    $data;
}
```

## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
