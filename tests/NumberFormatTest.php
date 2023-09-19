<?php

namespace Root23\JsonCanonicalizer\Tests;

use PHPUnit\Framework\TestCase;
use Root23\JsonCanonicalizer\Converter;

class NumberFormatTest extends TestCase
{
    public function testOk(): void
    {
        foreach ($this->getTestData() as [$number, $expected]) {
            $unpacked = unpack('E', hex2bin($number))[1];

            $actual = Converter::toEs6NumberFormat($unpacked);
            self::assertEquals($expected, $actual);
        }
    }

    private function getTestData(): \Generator
    {
        yield ['4340000000000001', '9007199254740994'];
        yield ['4340000000000002', '9007199254740996'];
        yield ['444b1ae4d6e2ef50', '1e+21'];
        yield ['3eb0c6f7a0b5ed8d', '0.000001'];
        yield ['8000000000000000', '0'];
        yield ['0000000000000000', '0'];
    }
}
