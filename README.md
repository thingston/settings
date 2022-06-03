# Thingston Settings

A simple but effective read-only settings package for PHP 8.1.

## Requirements

- PHP 8.1

## Instalation

`composer require lince/settings`

## Usage

Simply create a new instance from an array:

```php
<?php

use Thingston\Settings\Settings;

$settings = new Settings([
    'foo' => 'bar',
]);

if ($settings->has('foo')) {
    $foo = $settings->get('foo');
}
```

> The `$settings` argument must be an associative array where all keys must be a non-empty string.
> Allowed values are `scalar`, `array` and other instances of `[SettingsInterface](src/SettingsInterface.php)`

## Support

- Issues: https://github.com/thingston/settings/issues
- Documentation: https://github.com/thingston/settings/wiki