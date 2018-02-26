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

namespace Nekman\LuhnAlgorithm\Contract;

/**
 * Handles the Luhn Algorithm.
 * 
 * @link http://en.wikipedia.org/wiki/Luhn_algorithm 
 */
interface LuhnAlgorithmInterface {
    /**
     * Determine if a number is valid according to the Luhn Algorithm.
     * 
     * @param string $number The number to validate.
     * 
     * @return bool true if number is valid, false otherwise.
     * 
     * @throws \InvalidArgumentException If the input is invalid.
     */
    public function isValid(string $number): bool;

    /**
     * Calculate the check digit for an input.
     * 
     * @param int $numberWithoutCheckDigit The number, without check digit, to calculate the check digit for.
     * 
     * @return int The check digit.
     * 
     * @throws \InvalidArgumentException If the input is invalid.
     */
    public function calcCheckDigit(int $numberWithoutCheckDigit): int;

    /**
     * Calulates the checksum for number.
     * 
     * @param int $numberWithoutCheckDigit The number, without check digit, to calculate the checksum for.
     * 
     * @return int The checksum.
     * 
     * @throws \InvalidArgumentException If the input is invalid.
     */
    public function calcChecksum(int $numberWithoutCheckDigit): int;
}
