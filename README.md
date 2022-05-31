# Thingston Settings

A simple but effective read-only settings package for PHP 8.1.

## Requirements

- PHP 8.1

## Instalation

`composer require lince/settings`

## Usage

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

## Support

- Issues: https://github.com/thingston/settings/issues
- Documentation: https://github.com/thingston/settings/wiki