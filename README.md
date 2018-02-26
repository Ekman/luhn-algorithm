# Luhn Algorithm

[![Build Status](https://travis-ci.org/Ekman/Luhn-Algorithm.svg?branch=master)](https://travis-ci.org/Ekman/Luhn-Algorithm)

This is an implementation of the Luhn Algorithm in PHP. The Luhn Algorithm is
used to validate things like credit cards and national identification numbers.
More information on the algorithm can be found at [Wikipedia](http://en.wikipedia.org/wiki/Luhn_algorithm).

## Installation

Install with [Composer](https://getcomposer.org/):

```bash
composer require nekman/luhn-algorithm
```

## Usage

Use the class like this:

```php
use Nekman\LuhnAlgorithm\LuhnAlgorithmFactory;
use Nekman\LuhnAlgorithm\Number;

$luhn = LuhnAlgorithmFactory::create();

// Validate a credit card number entered in a form.
$ccNumber = Number::fromString($creditCard);
if ($luhn->isValid($ccNumber)) {
	// Credit card number is valid.
}

// These methods are used internally by the library. You're free
// to make use of them as well.
$number = new Number(12345);

$checksum = $luhn->calcChecksum($number);

$checkDigit = $luhn->calcCheckDigit($number);
```