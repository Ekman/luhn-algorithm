# Luhn Algorithm

[![Build Status](https://travis-ci.org/Ekman/Luhn-Algorithm.svg?branch=master)](https://travis-ci.org/Ekman/Luhn-Algorithm)

This is an implementation of the Luhn Algorithm for PHP and HHVM. The Luhn Algorithm is
used to validate things like credit cards and national identification numbers.
More information on the algorithm can be found at [Wikipedia](http://en.wikipedia.org/wiki/Luhn_algorithm).

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

You can find [the public interface of the library in the `LuhnAlgorithmInterface`](src/Contract/LuhnAlgorithmInterface.php).

[The `Number` class](src/Number.php) is a container class that holds the actual number and the check digit. It does no validation
nor does it calculate the check digit. To simplify the process of validating a number you can use the
named constructor `Number::fromString()` like this:
 
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
