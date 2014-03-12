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

/**
 * Apply the Luhn Algorithm to a number.
 *  
 * @link http://en.wikipedia.org/wiki/Luhn_algorithm 
 * @author Niklas Ekman <nikl.ekman@gmail.com>
 * @version 2014-02-07
 */
class LuhnAlgorithm {

	private $number;
	private $nDigits;
	private $checkDigit;

	/**
	 * Set number that the instance should handle.
	 * @param sting|int $number Number in string or int format
	 * @param bool $withCheckDigit [Defaults to true] <br> Is the check digit
	 * included in $number?
	 */
	function __construct($number, $withCheckDigit = true) {
		$this->setNumber($number, $withCheckDigit);
	}

	/**
	 * Validate according to the Luhn Algorithm
	 * @return bool true if valid
	 * @throws InvalidArgumentException If value is null
	 */
	public function isValid() {
		$checksum = self::calculateChecksum($this->number . $this->checkDigit, $this->nDigits + 1);
		// If the checksum  is divisible by 10 it is valid
		return ($checksum % 10) === 0;
	}

	/**
	 * Calculate the checksum from a number
	 * @param string $number Number to calculate checksum of
	 * @param int $length [Defaults to 0] <br> Length of $number. Function
	 * will calculate it if not supplied
	 * @return int Checksum
	 */
	public static function calculateChecksum($number, $length = 0) {
		$number = strval(self::toInteger($number));

		if ($length === 0) {
			$length = strlen($number);
		}

		$checkSum = 0;

		// Start at the next last digit
		for ($i = $length - 2; $i >= 0; $i -= 2) {
			// Multiply number with 2
			$tmp = intval($number[$i]) * 2;

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
			$checkSum += intval($number[$i]);
		}

		return $checkSum;
	}

	/**
	 * Calculate the checkdigit from a number
	 * @param type $number
	 * @return type
	 */
	public static function calculcateCheckDigit($number) {
		// Get the checksum
		$checkSum = strval(self::calculateChecksum($number . 0));
		// Get the last digit of the checksum
		$checkDigit = intval($checkSum[strlen($checkSum) - 1]);

		// If the checkdigit is not 0, then subtract the  value from 10
		return $checkDigit === 0 ? $checkDigit : 10 - $checkDigit;
	}

	/**
	 * Calculate the checkdigit and verify it
	 * @return bool true if checkdigit is correct
	 */
	public function isValidCheckDigit() {
		$checkDigit = self::calculcateCheckDigit($this->number);
		// Validate
		return $checkDigit === $this->checkDigit;
	}

	/**
	 * Validate the number by checking both the checksum and check digit
	 * @return bool true if completely valid
	 */
	public function isCompletelyValid() {
		return $this->isValid() && $this->isValidCheckDigit();
	}

	/**
	 * Get the number
	 * @param bool $withCheckDigit If the number should include a checkdigit
	 * @return string Number
	 */
	public function getNumber($withCheckDigit = true) {
		return $this->number . ($withCheckDigit === true ? $this->checkDigit : '');
	}

	/**
	 * Get the checkdigit of the number
	 * @return int Checkdigit
	 */
	public function getCheckDigit() {
		return $this->checkDigit;
	}

	/**
	 * Remove all but numbers from a string
	 * 
	 * @param string $string String to "convert" to integer
	 * @return string String containing only numbers
	 */
	public static function toInteger($string) {
		return preg_replace("/[^\d]/", "", $string);
	}

	/**
	 * Set number that the instance should handle.
	 * @param sting|int $number Number in string or int format
	 * @param bool $withCheckDigit [Defaults to true] <br> Is the check digit
	 * included in $number?
	 */
	public function setNumber($number, $withCheckDigit = true) {
		$number = strval(self::toInteger($number));
		$length = strlen($number);

		// If number does not include checkdigit, calculate it!
		if (!$withCheckDigit) {
			$this->checkDigit = self::calculcateCheckDigit($number);
		} else {
			// Extract check digit from the number
			$this->checkDigit = intval($number[$length - 1]);
			$number = substr($number, 0, $length - 1);
			// Fix length
			$length--;
		}

		$this->number = $number;
		$this->nDigits = $length;
	}

}
