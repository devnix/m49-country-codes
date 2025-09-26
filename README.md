# devnix/m49-country-codes

A PHP package to convert actual and old m49 country codes to ISO 3166-1 alpha-2

## Installation

```shell
composer require devnix/m49-country-codes
```

## Usage

```php
$m49Finder = new Devnix\M49\Finder();

$m49Finder->m49ToIso31661alpha2(276); // 'DE'

$m49Finder->obsoleteM49ToIso31661alpha2(280); // 'DE'
$m49Finder->obsoleteM49ToIso31661alpha2(278); // 'DE'
```