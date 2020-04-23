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
use Nekman\LuhnAlgorithm\Exceptions\ArgumentIsNotNumericException;
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
            "String" => ["410321-9202", new Number('410321920', 2)],
            "Integer" => [4103219202, new Number('410321920', 2)],
            "Large number" => ['89148000003974165685', new Number('8914800000397416568', 5)],
            "Character in string" => ['abc123', new Number('12', 3)],
            "Larger than INT_MAX" => ['922337203685477580721', new Number('92233720368547758072', 1)],
        ];
    }

    /**
     * @dataProvider provideFromString_fail
     */
    public function testFromString_fail($number, $expected)
    {
        $this->expectException($expected);
        Number::fromString($number);
    }

    public function provideFromString_fail()
    {
        return [
            "Empty string" => ['', \InvalidArgumentException::class],
            "Invalid string" => ['xyz ', \InvalidArgumentException::class],
            "Should be ArgumentIsNotNullException" => ["foo", ArgumentIsNotNumericException::class],
            "Should be LuhnAlgorithmExceptionInterface" => ["bar", LuhnAlgorithmExceptionInterface::class],
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
            "Valid number" => [new Number(12345, 5), "123455"]
        ];
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
            "Invalid number" => ['abc123', 1, \InvalidArgumentException::class],
            "Whitespace" => ['123 ', null, \InvalidArgumentException::class],
            "Should be ArgumentIsNotNullException" => ["foo", null, ArgumentIsNotNumericException::class],
            "Should be LuhnAlgorithmExceptionInterface" => ["bar", null, LuhnAlgorithmExceptionInterface::class],
        ];
    }

    /**
     * @dataProvider provideProperties
     */
    public function testProperties($input, $checkDigit)
    {
        $number = new Number($input, $checkDigit);
        $this->assertEquals($input, $number->getNumber());
        $this->assertEquals($checkDigit, $number->getCheckDigit());
    }

    public function provideProperties()
    {
        return [
            "Valid number and check digit" => [123, 1],
            "Valid number and check digit (null)" => [123, null],
        ];
    }

    public function testSerialize()
    {
        $number = new Number(133, 7);
        $serialized = serialize($number);
        $other = unserialize($serialized);
        $this->assertInstanceOf(Number::class, $other);
        $this->assertEquals(133, $other->getNumber());
        $this->assertEquals(7, $other->getCheckDigit());
    }
}
