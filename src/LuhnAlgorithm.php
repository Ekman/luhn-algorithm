<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Niklas Ekman
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Nekman\LuhnAlgorithm;

use Nekman\LuhnAlgorithm\Contract\LuhnAlgorithmInterface;

/**
 * Handles the Luhn Algorithm.
 * 
 * @link http://en.wikipedia.org/wiki/Luhn_algorithm 
 */
class LuhnAlgorithm implements LuhnAlgorithmInterface {
	/**
	 * {@inheritDoc}
	 */
	public function isValid(string $input): bool {
		// Remove everything except digits from the input.
		$number = (int) preg_replace("/[^\d]/", "", $input);
		
		$checksum = $this->calcChecksum($number);

		// If the checksum  is divisible by 10 it is valid
		return ($checksum % 10) === 0;
	}

	/**
	 * {@inheritDoc}
	 */
	public function calcCheckDigit(int $input): int {
		$checkSum = (string) $this->calcChecksum($input . 0);
		
		// Get the last digit of the checksum
		$checkDigit = (int) $checkSum[strlen($checkSum) - 1];

		// If the checkdigit is not 0, then subtract the  value from 10
		return $checkDigit === 0 ? $checkDigit : 10 - $checkDigit;
	}

	/**
	 * {@inheritDoc}
	 */
	public function calcChecksum(int $input): int {
		$input = (string) $input;
		$length = strlen($input);

		$checkSum = 0;

		// Start at the next last digit
		for ($i = $length - 2; $i >= 0; $i -= 2) {
			// Multiply number with 2
			$tmp = (int) ($input[$i]) * 2;

			// If a 2 digit number, split and add togheter
			if ($tmp > 9) {
				$tmp = ($tmp / 10) + ($tmp % 10);
			}

			// Sum it upp
			$checkSum += $tmp;
		}

		// Start at the next last digit
		for ($i = $length - 1; $i >= 0; $i -= 2) {
			// Sum it upp
			$checkSum += (int) $input[$i];
		}

		return $checkSum;
	}
}
