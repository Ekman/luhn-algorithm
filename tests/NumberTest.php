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
     * @dataProvider provideWithCheckDigit_success
     */
    public function testWithCheckDigit_success($number, $expected)
    {
        $this->assertEquals($expected, Number::fromString($number));
    }

    public function provideWithCheckDigit_success()
    {
        return [
            ["410321-9202", new Number(410321920, 2)],
            [4103219202, new Number(410321920, 2)],
            ['89148000003974165685', new Number(8914800000397416568, 5)],
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
}
