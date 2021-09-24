# Affordable and intuitive logging backend for your apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/loghouse-io/loghouse-laravel.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/loghouse-io/loghouse-laravel.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-laravel)

LogHouse is a logging management system that allows you to store hundreds of gigabytes of logs with almost no configuration and with blazing fast ingestion and querying speed.
## Installation

You can install the package via composer:

```bash
composer require loghouse-io/loghouse-laravel
```

## Usage

1. You need to add 2 parameters to the .env file
```
LOGHOUSE_LARAVEL_ACCESS_TOKEN=${LOGHOUSE_LARAVEL_ACCESS_TOKEN}
LOGHOUSE_LARAVEL_DEFAULT_BUCKET_ID=${LOGHOUSE_LARAVEL_DEFAULT_BUCKET_ID}
```
2. You should place a call to this method in your `bootstrap/app.php` file right before the $app variable is returned by the file
```php
$app->configureMonologUsing(function ($monolog) {
    $monolog->pushHandler(new LoghouseLaravelHandler);
});
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

## Credits

-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
