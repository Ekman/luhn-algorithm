# Luhn Algorithm in PHP

This is an implementation of the Luhn Algorithm in PHP. The Luhn Algorithm is
used to validate things like credit cards and national identifcation numbers.
More information on the algorithm can be found at [Wikipedia](http://en.wikipedia.org/wiki/Luhn_algorithm)

## Installation

Can be installed using composer:
```bash
composer require nekman/luhn-algorithm
```

## Usage

Use the class like this:

```php
use Nekman\LuhnAlgorithm\LuhnAlgorithmFactory;

$luhn = LuhnAlgorithmFactory::create();

if ($luhn->isValid(123456789)) {
	// Number is valid.
}

$checkSum = $luhn->calcCheckSum(123456789);

$checkDigit = $luhn->calcCheckDigit();
```
