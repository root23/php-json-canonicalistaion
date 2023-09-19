<?php

namespace Root23\JsonCanonicalizator\Tests;

use PHPUnit\Framework\TestCase;
use Root23\JsonCanonicalizator\Helpers;

class NumberFormatTest extends TestCase
{
    public function testOk(): void
    {
        foreach ($this->getTestData() as [$number, $expected]) {
            $unpacked = unpack('E', hex2bin($number))[1];

            $actual = Helpers::es6NumberFormat($unpacked);
            self::assertEquals($expected, $actual);
        }
    }

    private function getTestData(): \Generator
    {
        $filePath = __DIR__ . '/TestData/es6_test_file.txt';

        if (file_exists($filePath) || !is_readable($filePath)) {
            yield ['4340000000000001', '9007199254740994'];
            yield ['4340000000000002', '9007199254740996'];
            yield ['444b1ae4d6e2ef50', '1e+21'];
            yield ['3eb0c6f7a0b5ed8d', '0.000001'];
            yield ['3eb0c6f7a0b5ed8c', '9.999999999999997e-7'];
            yield ['8000000000000000', '0'];
            yield ['0000000000000000', '0'];
            return;
        }

        $file = fopen($filePath, 'rb');
        while ($line = fgets($file)) {
            [$n, $e] = explode(',', $line);

            $n = trim($n);
            $n = str_pad($n, 16, '0', \STR_PAD_LEFT);

            $e = trim($e);

            yield [trim($n), trim($e)];
        }
    }
}
