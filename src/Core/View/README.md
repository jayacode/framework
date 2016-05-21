# JayaCode Template Engine

jayacode template engine package

## Requirements
* PHP >= 5.5

## Usage
Echo'ed contents and automatically escaped using htmlspecialchars()
``` php
{{ $variable }}

{{ xfunction() }}
```

PHP code block (multi line)
```php
[[ phpcode ]]
```

a line of PHP code.
```php
@line
```


extend a template from another one.
```php
[@ parent name_parent @]
```

## Examples
```php
// index.php
<?php
use JayaCode\Framework\Core\View\View;

require_once "vendor/autoload.php";

$templateEngine = new View($viewDir);

/**
 * if using cache & global variable
 * $templateEngine = new View($viewDir, ['globalVar' => 'valueVar'], ["cacheDir" => $pathCacheDir]);
 */

$template = $templateEngine->template($nameTemplate); // path.subpath == path/subpath

$users = [
    [
        "firstname" => "Restu",
        "lastname" => "Suhendar",
    ],
    [
        "firstname" => "Cakra",
        "lastname" => "Buana",
    ]
];

$template->vars->add(["users" => $users);

print $template->render();
```

template file (nameTemplate.vj)
```php
[[
function fullName($firstName, $lastName) {
    return "{$firstName} {$lastName}";
}
]]

<h1>User list</h1>
<table>
    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Fullname</th>
    <tr>
    </thead>
    <tbody>
        @if (count($users) > 0):
            @foreach($users as $user):
                <tr>
                    <td>{{ $user['firstname'] }}</td>
                    <td>{{ $user['lastname'] }}</td>
                    <td>{{ fullName($user['firstname'], $user['lastname']) }}</td>
                </tr>
            @endforeach
        @else:
            <tr>
                <td colspan="2">User not found</td>
            </tr>
        @endif
    </tbody>
</table>
```
### Inheritance

parent : master.vj
```php
<html>
<head>
    <title>
        [@ content title @] Defult Value Content Title [@ endcontent @]
    </title>
</head>
<body>
<h1>Inheritance</h1>

[@ content body @]

</body>
</html>
```

child : child.vj
```php
[@ content title @]Title Page[@ endcontent @]

[@ content body @]
Hello {{ $variableName }}
[@ endcontent @]
```

call template :
```php
$template = $viewEngine->template('child');
$template->vars->add('variableName', 'JayaCode');

print $template->render();
```
## Credits

- [Restu Suhendar][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/aarestu
