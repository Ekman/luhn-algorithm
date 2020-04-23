<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2020 Niklas Ekman
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

use Nekman\LuhnAlgorithm\Contract\LuhnAlgorithmExceptionInterface;
use Nekman\LuhnAlgorithm\Exceptions\MissingCheckDigitException;
use Nekman\LuhnAlgorithm\LuhnAlgorithm;
use Nekman\LuhnAlgorithm\Number;
use PHPUnit\Framework\TestCase;

class LuhnAlgorithmTest extends TestCase
{
    /**
     * @var LuhnAlgorithm
     */
    private $luhn;

    protected function setUp()
    {
        parent::setUp();
        
        $this->luhn = new LuhnAlgorithm();
    }

    /**
     * @dataProvider provideIsValid_success
     */
    public function testIsValid_success($number, $expected)
    {
        $this->assertEquals($expected, $this->luhn->isValid($number));
    }

    public function provideIsValid_success()
    {
        return [
            "Valid number" => [new Number('12345', 5), true],
            "Zero" => [new Number('0', 0), true],
            "Larger than INT_MAX" => [new Number('92233720368547758072', 8), true],
            "Invalid number" => [new Number('12345', 6), false],
            "Swedish company organization ID" => [new Number(559114884, 5), true],
            "Swedish organization number" => [new Number(640319261, 7), true],
        ];
    }

    /**
     * @dataProvider provideIsValid_failure
     */
    public function testIsValid_failure($number, $exception)
    {
        $this->expectException($exception);
        $this->luhn->isValid($number);
    }

    public function provideIsValid_failure()
    {
        return [
            "Invalid argument" => [new Number(123, null), \InvalidArgumentException::class],
            "Should be MissingCheckDigitException" => [new Number(123, null), MissingCheckDigitException::class],
            "Should be LuhnAlgorithmExceptionInterface" => [new Number(123, null), LuhnAlgorithmExceptionInterface::class],
        ];
    }

    /**
     * @dataProvider provideCalcChecksum_success
     */
    public function testCalcChecksum_success($number, $expected)
    {
        $this->assertEquals($expected, $this->luhn->calcChecksum($number));
    }

    public function provideCalcChecksum_success()
    {
        return [
            "Valid checksum" => [new Number(3199723370002), 50],
        ];
    }

    /**
     * @dataProvider provideCalcCheckDigit_success
     */
    public function testCalcCheckDigit_success($number, $expected)
    {
        $this->assertEquals($expected, $this->luhn->calcCheckDigit($number));
    }

    public function provideCalcCheckDigit_success()
    {
        return [
            "Valid number" => [new Number(12345), 5],
            "Swedish company organization ID" => [new Number(559114884), 5],
            "Swedish organization number" => [new Number(640319261), 7],
        ];
    }
}
