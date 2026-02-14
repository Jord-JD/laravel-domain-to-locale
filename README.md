# Laravel Domain To Locale

Change your Laravel app's locale based on the domain name.

## Installation

To install the Laravel Domain To Locale package, just run
the following Composer command from the root of your
project.

```bash
composer require jord-jd/laravel-domain-to-locale
```

## Setup

This package requires you to register a global middleware
within your `app\Http\Kernel.php` file. Just add the
line below to your `$middleware` array.

```php
\DivineOmega\LaravelDomainToLocale\Http\Middleware\DomainToLocale::class,
```

After installation, the config file must be setup within
your project. To do so, simply run the following Artisan
command.

```bash
php artisan vendor:publish --provider="DivineOmega\LaravelDomainToLocale\ServiceProvider"
```

## Configuration

The published configuration file for this package 
can be found at `config/domain-to-locale.php`.
This file defines a map between domain name and locale,
as shown in the example below.

```php
<?php

return [

    // Define the mapping from domain name to locale

    'map' => [

        'example.com'   => 'en',
        'example.co.uk' => 'en',
        'example.pl'    => 'pl',
        'example.de'    => 'de',
        'example.fr'    => 'fr',

    ]

];
```

Adding new lines to the `map` array will allow you to
specify which domain names should set which locales.
Once configured, everything else is automatic.
