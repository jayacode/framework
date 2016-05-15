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

### Create Connection
```php
// ...

$db = Database::create([
    "driver" => "mysql",

    "host" => "localhost",
    "username" => "root",
    "password" => "",

    "dbname" => "test",
    "options" => []
]);

// ...
```

### Class Model

```php
class GuestBook extends \JayaCode\Framework\Core\Database\Model\Model
{
    protected static $table = "guestbook";
}

GuestBook::$db = $db;
```

### Retrieving Models

```php
$mr = GuestBook::select()->like("name", "Mr.%")->first();
if ($mr) {
    // Accessing Column Values
    echo $mr->name;
}

// get all data
$guests = GuestBook::select()->all();

foreach ($guests as $guest) {
    echo $guest->name;
}
```

### Inserting Models

```php
$guest = new GuestBook();

$guest->name = "restu";
$guest->save();
```

### Updating Models

```php
$guest = GuestBook::select()->where("id", 1)->first();

$guest->name = "restu suhendar";
$guest->save();
```

### Deleting Models

```php
$guest = GuestBook::select()->where("id", 1)->first();

$guest->delete();
```

## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
