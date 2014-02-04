<?php

/*
  Copyright 2013 Niklas Ekman, nikl.ekman@gmail.com

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */

/**
 * Apply the Luhn Algorithm to a number.
 *  
 * @link http://en.wikipedia.org/wiki/Luhn_algorithm Go to Wikipedia for more
 * info on the Luhn Alorithm
 * 
 * @author Niklas Ekman <nikl.ekman@gmail.com>
 * @version 2014-02-04
 */
class LuhnAlgorithm {

	private $number;
	private $nDigits;
	private $checkDigit;

	/**
	 * The number can contain other signs then numbers, for instance 
	 * whitespace; <b>123 456 789</b>, these will be stripped
	 * away.
	 * @param string|int $number String or int
	 * @param bool $withCheckDigit If the number contains a checkdigit already
	 * @throws InvalidArgumentException If the string is less than 2 numbers
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
	 * @param string $number
	 * @return int Checksum
	 */
	public static function calculateChecksum($number, $length = null) {
		if (!is_string($number)) {
			$number = strval($number);
		}

		if ($length === null) {
			$length = strlen($number);
		}

		$checkSum = 0;

		// Start at the next last digit
		for ($i = $length - 2; $i >= 0; $i -= 2) {
			// Multiply number with 2
			$tmp = intval($number[$i]) * 2;

			// If a 2 digit number, split and add togheter
			if ($tmp > 9) {
				$tmp = intval($tmp / 10) + intval($tmp % 10);
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
		$checkSum = strval(self::calculateChecksum($number));
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
		$checkDigit = self::calculcateCheckDigit($this->number . 0, $this->nDigits + 1);
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
	 * The number can contain other signs then numbers, for instance 
	 * whitespace; <b>123 456 789</b>, these will be stripped
	 * away.
	 * @param string|int $number String or int
	 * @param bool $withCheckDigit If the number contains a checkdigit already
	 * @throws InvalidArgumentException If the string is less than 2 numbers
	 */
	public function setNumber($number, $withCheckDigit = true) {
		// Validate the number
		if (preg_match("/\d{6}\s?-?\s?\d{4}/", $number) !== 0) {
			throw new InvalidArgumentException('Number must be numeric');
		}

		$number = strval(intval($number));

		// Pretty safe to say that we need more then 1 number to be able to do
		// the Luhn Algorithm
		$length = strlen($number);
		if ($length <= 1) {
			throw new InvalidArgumentException('Length must be longer then 1');
		}

		// If number does not include checkdigit, calculate it!
		if ($withCheckDigit === false) {
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
