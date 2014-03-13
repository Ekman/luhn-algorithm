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

require_once(dirname(__FILE__) . "/LuhnAlgorithm.php");

/**
 * Extends LuhnAlgorithm and makes sure that the number supplied is a valid
 * personnummer.
 *  
 * @author Niklas Ekman <nikl.ekman@gmail.com>
 * @version 2014-02-07
 */
class Personnumer extends \LuhnAlgorithm {

	/**
	 * Validate an input and see if it can be a valid personnumer
	 * @param type $input
	 * @return type
	 */
	public static function isValid($input) {
		return preg_match("/^\d{2}[0-1]\d[0-3]\d\s?-?\s?\d{4}$/", trim($input)) !== false;
	}

	/**
	 * The number must be in the format <b>XXXXXX-XXX(D)</b> or
	 * <b>XXXXXX - XXX(D)</b> or any permutations of those two. If the 
	 * checkdigit (D) is not supplied, it will be calculated
	 * 
	 * @param string|int $number The personnumer or organizational number
	 * @param bool $withCheckDigit [Defaults to true] <br> Is the check digit
	 * included in $number?
	 * @throws InvalidArgumentException
	 */
	public function setNumber($number, $withCheckDigit = true) {
		if (!static::isValid($number)) {
			throw new \InvalidArgumentException("{$number} is not a valid personnummer");
		}

		parent::setNumber($number, $withCheckDigit);
	}

	/**
	 * Calculate the checksum from a number
	 * @param string $number Number to calculate checksum of
	 * @param int $length [Defaults to 0] <br> Length of $number. Function
	 * will calculate it if not supplied
	 * @return int Checksum
	 * @throws InvalidArgumentException
	 */
	public static function calculateChecksum($number, $length = 0) {
		if (!static::isValid($number)) {
			throw new \InvalidArgumentException("{$number} is not a valid personnummer");
		}

		return \LuhnAlgorithm::calculateChecksum($number, $length);
	}

}
