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

use Nekman\LuhnAlgorithm\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    /**
     * @dataProvider provideFromString_success
     */
    public function testFromString_success($number, $expected)
    {
        $this->assertEquals($expected, Number::fromString($number));
    }

    public function provideFromString_success()
    {
        return [
            ["410321-9202", new Number(410321920, 2)],
            [4103219202, new Number(410321920, 2)],
            ['89148000003974165685', new Number(8914800000397416568, 5)],
            ['abc123', new Number(12, 3)],
        ];
    }

    /**
     * @dataProvider provideFromString_fail
     */
    public function testFromString_fail($number, $checkDigit, $expected)
    {
        $this->expectException($expected);
        new Number($number, $checkDigit);
    }

    public function provideFromString_fail()
    {
        return [
            ['', 1, \InvalidArgumentException::class],
            ['xyz ', null, \InvalidArgumentException::class],
        ];
    }

    /**
     * @dataProvider provideToString_success
     */
    public function testToString_success($number, $expected)
    {
        $this->assertEquals($expected, (string) $number);
    }

    public function provideToString_success()
    {
        return [
            [new Number(12345, 5), "123455"]
        ];
    }

    public function testIntMax()
    {
        // Use any number that is larger then PHP_INT_MAX.
        $largeNumber = ((string) PHP_INT_MAX).'2';
        $checkDigit = 1;
        $number = Number::fromString($largeNumber.$checkDigit);

        $this->assertEquals($largeNumber, $number->getNumber());
        $this->assertEquals($checkDigit, $number->getCheckDigit());
    }

    /**
     * @dataProvider provideNew_fail
     */
    public function testNew_fail($number, $checkDigit, $expected)
    {
        $this->expectException($expected);
        new Number($number, $checkDigit);
    }

    public function provideNew_fail()
    {
        return [
            ['abc123', 1, \InvalidArgumentException::class],
            ['123 ', null, \InvalidArgumentException::class],
        ];
    }
}
