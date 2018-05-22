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

declare(strict_types=1);

namespace Nekman\LuhnAlgorithm;

use Nekman\LuhnAlgorithm\Contract\NumberInterface;

/**
 * Input for the Luhn Algorithm contains a number and a check digit.
 */
class Number implements NumberInterface
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var int|null
     */
    private $checkDigit;

    /**
     * Input constructor.
     * @param string $number The number.
     * @param int|null $checkDigit [Optional] The check digit for the number.
     */
    public function __construct(string $number, int $checkDigit = null)
    {
        if (!is_numeric($number)) {
            throw new \InvalidArgumentException("Expects \$number to be a number, \"{$number}\" given.");
        }

        $this->number = $number;
        $this->checkDigit = $checkDigit;
    }

    /**
     * Create a new number from an input that contains the check digit
     * already.
     *
     * @param string $input The input that contains the check digit already.
     *
     * @return self
     */
    public static function fromString(string $input): self
    {
        $input = preg_replace('/[^\d]/', '', $input);

        if (!is_numeric($input)) {
            throw new \InvalidArgumentException("Expects \$input to be a number, \"{$input}\" given.");
        }

        // Get the last digit.
        $checkDigit = (int) $input[strlen($input) - 1];

        // Remove the last digit.
        $number = substr($input, 0, strlen($input) - 1);

        return new self($number, $checkDigit);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckDigit(): ?int
    {
        return $this->checkDigit;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->number . (string) $this->checkDigit;
    }
}
