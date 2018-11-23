<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2018 Niklas Ekman
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

use Nekman\LuhnAlgorithm\LuhnAlgorithm;
use Nekman\LuhnAlgorithm\Number;
use PHPUnit\Framework\TestCase;

class LuhnAlgorithmTest extends TestCase
{
    /**
     * @var LuhnAlgorithm
     */
    private $luhn;

    public function setUp()
    {
        parent::setUp();
        
        $this->luhn = new LuhnAlgorithm();
    }

    /**
     * @dataProvider provideIsValid_success
     */
    public function testIsValid_success($number, $expected, $purpose)
    {
        $this->assertEquals($expected, $this->luhn->isValid($number), $purpose);
    }

    public function provideIsValid_success()
    {
        return [
            [new Number('12345', 5), true, "Valid number"],
            [new Number('0', 0), true, "Zero"],
            [new Number('92233720368547758072', 8), true, "Larger than INT_MAX"],
            [new Number('12345', 6), false, "Invalid number"],
        ];
    }

    /**
     * @dataProvider provideIsValid_failure
     */
    public function testIsValid_failure($number, $exception, $purpose)
    {
        $this->expectException($exception, $purpose);
        $this->luhn->isValid($number);
    }

    public function provideIsValid_failure()
    {
        return [
            [new Number(123, null), \InvalidArgumentException::class, "Invalid argument"],
        ];
    }

    /**
     * @dataProvider provideCalcChecksum_success
     */
    public function testCalcChecksum_success($number, $expected, $purpose)
    {
        $this->assertEquals($expected, $this->luhn->calcChecksum($number), $purpose);
    }

    public function provideCalcChecksum_success()
    {
        return [
            [new Number(3199723370002), 50, "Valid checksum"],
        ];
    }

    /**
     * @dataProvider provideCalcCheckDigit_success
     */
    public function testCalcCheckDigit_success($number, $expected, $purpose)
    {
        $this->assertEquals($expected, $this->luhn->calcCheckDigit($number));
    }

    public function provideCalcCheckDigit_success()
    {
        return [
            [new Number(12345), 5, "Valid number"],
            [new Number(559114884), 5, "Swedish company organization ID"],
        ];
    }
}
