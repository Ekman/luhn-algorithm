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

namespace Nekman\LuhnAlgorithm\Test;

use PHPUnit\Framework\TestCase;
use Nekman\LuhnAlgorithm\LuhnAlgorithm;

class LuhnAlgorithmTest extends TestCase {
	/**
	 * @var LuhnAlgorithm
	 */
	private $luhn;

	public function setUp() {
		parent::setUp();
		
		$this->luhn = new LuhnAlgorithm();
	}

	/**
	 * @dataProvider provideIsValid_success
	 */
	public function testIsValid_success($number, $expected) {
		$this->assertEquals($expected, $this->luhn->isValid($number));
	}

	public function provideIsValid_success() {
		return [
			["410321-9202", true],
			[123455, true],
			[4103219202, true],
			[31997233700020, true],
		];
	}

	/**
	 * @dataProvider provideCalcChecksum_success
	 */
	public function testCalcChecksum_success($number, $expected) {
		$this->assertEquals($expected, $this->luhn->calcChecksum($number));
	}

	public function provideCalcChecksum_success() {
		return [
			[3199723370002, 50],
		];
	}

	/**
	 * @dataProvider provideCalcCheckDigit_success
	 */
	public function testCalcCheckDigit_success($number, $expected) {
		$this->assertEquals($expected, $this->luhn->calcCheckDigit($number));
	}

	public function provideCalcCheckDigit_success() {
		return [
			[12345, 5],
			[410321920, 2],
			[3199723370002, 0],
		];
	}
}
