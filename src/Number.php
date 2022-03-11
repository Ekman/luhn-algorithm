<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2021 Niklas Ekman
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

use Nekman\LuhnAlgorithm\Contract\LuhnAlgorithmExceptionInterface;
use Nekman\LuhnAlgorithm\Contract\NumberInterface;
use Nekman\LuhnAlgorithm\Exceptions\ArgumentIsNotNumericException;
use function Nekman\LuhnAlgorithm\Functions\string_is_numeric;
use Serializable;

/**
 * Input for the Luhn Algorithm contains a number and a check digit.
 */
class Number implements NumberInterface, Serializable
{
	private string $number;
	private ?int $checkDigit;

	/**
	 * @param string $number The number.
	 * @param int|null $checkDigit [Optional] The check digit for the number.
	 * @throws ArgumentIsNotNumericException If the number input does not consist entirely of numbers.
	 */
	public function __construct(string $number, int $checkDigit = null)
	{
		if (!string_is_numeric($number)) {
			throw new ArgumentIsNotNumericException($number);
		}

		$this->number = $number;
		$this->checkDigit = $checkDigit;
	}

	/**
	 * Create a new number from an input that contains the check digit already
	 * @param string $input The input that contains the check digit already.
	 * @return self
	 *
	 * @throws LuhnAlgorithmExceptionInterface
	 * @throws ArgumentIsNotNumericException If the input does not consist entirely of numbers.
	 */
	public static function fromString(string $input): self
	{
		$input = preg_replace('/[^\d]/', '', $input);

		if (!string_is_numeric($input)) {
			throw new ArgumentIsNotNumericException($input);
		}

		$lastIndex = strlen($input) - 1;

		// Get the last digit.
		$checkDigit = (int)$input[$lastIndex];

		// Remove the last digit.
		$number = substr($input, 0, $lastIndex);

		return new self($number, $checkDigit);
	}

	public function __toString(): string
	{
		return $this->number . $this->checkDigit;
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
	public function getNumber(): string
	{
		return $this->number;
	}

	public function serialize(): string
	{
		return serialize($this->__serialize());
	}

	public function __serialize(): array
	{
		return [$this->number, $this->checkDigit];
	}

	public function unserialize($data): void
	{
		$this->__unserialize(unserialize($data));
	}

	public function __unserialize(array $data): void
	{
		[$this->number, $this->checkDigit] = $data;
	}
}
