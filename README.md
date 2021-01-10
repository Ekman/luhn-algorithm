# Luhn Algorithm

[![Build Status](https://circleci.com/gh/Ekman/luhn-algorithm.svg?style=svg)](https://app.circleci.com/pipelines/github/Ekman/luhn-algorithm)
[![Coverage Status](https://coveralls.io/repos/github/Ekman/luhn-algorithm/badge.svg?branch=master)](https://coveralls.io/github/Ekman/luhn-algorithm?branch=master)

This is a zero dependency implementation of the Luhn Algorithm for PHP 7.0 and above. The Luhn Algorithm is used to validate things like credit cards and national identification numbers. More information on the algorithm can be found at [Wikipedia](http://en.wikipedia.org/wiki/Luhn_algorithm).

## Installation

Install with [Composer](https://getcomposer.org/):

```bash
composer require nekman/luhn-algorithm
```

## Usage

In order to instantiate a new instance of the library, use the factory:

 ```php
 use Nekman\LuhnAlgorithm\LuhnAlgorithmFactory;

 $luhn = LuhnAlgorithmFactory::create();
 ```

You can find [the library facade in the `LuhnAlgorithmInterface.php` file](src/Contract/LuhnAlgorithmInterface.php).

[The `Number` class](src/Number.php) is a container class that holds the actual number and the check digit. It does no validation nor does it calculate the check digit. It exists to clearly separate the number from the check digit and to define when the check digit exists or not. To simplify the process of validating a number you can use the named constructor `Number::fromString()` like this:

```php
use Nekman\LuhnAlgorithm\Number;

// Assume $creditCard is from a form.
$number = Number::fromString($creditCard);

if ($luhn->isValid($number)) {
    // Number is valid.
}
```

Alternatively, if you want to calculate the checksum or check digit for a number:

```php
use Nekman\LuhnAlgorithm\Number;

$number = new Number(12345);

$checksum = $luhn->calcChecksum($number);

$checkDigit = $luhn->calcCheckDigit($number);
```

## Changelog

For a complete list of changes, and how to migrate between major versions, see [releases page](https://github.com/Ekman/luhn-algorithm/releases).
