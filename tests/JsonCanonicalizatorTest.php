<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizator\Tests;

use PHPUnit\Framework\TestCase;
use Root23\JsonCanonicalizator\JsonCanonicalizatorFactory;

class JsonCanonicalizatorTest extends TestCase
{
    public function testArray(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('arrays');
        $output = $this->getOutputData('arrays', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testArrayHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('arrays');
        $output = $this->getOutputData('arrays', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    public function testRussian(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('russian');
        $output = $this->getOutputData('russian', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testRussianHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('russian');
        $output = $this->getOutputData('russian', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    public function testStructures(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('structures');
        $output = $this->getOutputData('structures', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testStructuresHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('structures');
        $output = $this->getOutputData('structures', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    public function testUnicode(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('unicode');
        $output = $this->getOutputData('unicode', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testUnicodeHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('unicode');
        $output = $this->getOutputData('unicode', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    public function testValues(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('values');
        $output = $this->getOutputData('values', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testValuesHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('values');
        $output = $this->getOutputData('values', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    public function testWeird(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('weird');
        $output = $this->getOutputData('weird', false);

        self::assertEquals($output, $instance->canonicalize($input, false));
    }

    public function testWeirdHex(): void
    {
        $instance = JsonCanonicalizatorFactory::getInstance();

        $input = $this->getInputData('weird');
        $output = $this->getOutputData('weird', true);

        self::assertEquals($output, $instance->canonicalize($input, true));
    }

    private function getInputData(string $fileName): mixed
    {
        $file = file_get_contents(__DIR__ . '/TestData/input/' . $fileName . '.json');

        return json_decode($file);
    }

    private function getOutputData(string $fileName, bool $isHex): string
    {
        $path = __DIR__ . '/TestData/output/'. $fileName;
        $path .= ($isHex) ? '_hex.txt' : '.txt';

        $file = file_get_contents($path);

        return rtrim(str_replace("\n", ' ', $file));
    }
}
