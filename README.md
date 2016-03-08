# Recoil Peridot Extension

[![Build Status](http://img.shields.io/travis/recoilphp/peridot/master.svg?style=flat-square)](https://travis-ci.org/recoilphp/peridot)
[![Code Coverage](https://img.shields.io/codecov/c/github/recoilphp/peridot/master.svg?style=flat-square)](https://codecov.io/github/recoilphp/peridot)

A [Peridot](https://github.com/peridot-php/peridot) extension that executes tests
as [Recoil](https://github.com/recoilphp/recoil) coroutines.

    composer require --sort-packages --dev recoil/peridot

## Usage

Simply return a new instance of `Recoil\Peridot\RecoilTestExecutor` in your Peridot
configuration file.

```php
use Recoil\Peridot\RecoilTestExecutor;

require __DIR__ . '/../vendor/autoload.php';

return new RecoilTestExecutor();
```

You can then use PHP generators as coroutines in your `beforeEach`, `afterEach`
and test functions.

## Building and testing

Please see [CONTRIBUTING.md](.github/CONTRIBUTING.md) for information about
running the tests and submitting changes.
