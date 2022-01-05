# Affordable and intuitive logging backend for your Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/loghouse-io/loghouse-laravel.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/loghouse-io/loghouse-laravel.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-laravel)

LogHouse is a logging management system that allows you to store hundreds of gigabytes of logs with almost no configuration and with blazing fast ingestion and querying speed.

This library provides integration for Laravel framework.

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

2. Next, add a new log channel to logging.php
```php
'channels' => [
        ...
        'loghouse' => [
            'driver' => 'custom',
            'via' => \LoghouseIo\LoghouseLaravel\LoghouseLaravelFactory::class
        ]
```
3. And at the end add this channel to the stack
```php
'channels' => [
        ...
        'stack' => [
            'driver' => 'stack',
            'channels' => [...,'loghouse'],
            ...
        ]
```

4. If you want to send logs to another bucket, for example, separate api, web and console logs, you must create a new channel in logging.php, and add bucket_id to the channel config
```php
'channels' => [
        ...
        'loghouse_api' => [
            'driver' => 'custom',
            'via' => \LoghouseIo\LoghouseLaravel\LoghouseLaravelFactory::class,
            'bucket_id' => ${bucket_id}
        ]
```

5. To use the new channel, paste the code into your project
```php
Log::channel('loghouse_api')->warning('Api log');
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
