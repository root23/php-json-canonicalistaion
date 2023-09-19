<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizer\Tests;

use PHPUnit\Framework\TestCase;
use Root23\JsonCanonicalizer\JsonCanonicalizer;

class JsonCanonicalizerTest extends TestCase
{
    public function testArray(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('arrays');
        $output = $this->getOutputData('arrays', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }
    public function testArrayHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('arrays');
        $output = $this->getOutputData('arrays', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
    }

    public function testRussian(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('russian');
        $output = $this->getOutputData('russian', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }

    public function testRussianHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('russian');
        $output = $this->getOutputData('russian', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
    }

    public function testStructures(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('structures');
        $output = $this->getOutputData('structures', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }

    public function testStructuresHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('structures');
        $output = $this->getOutputData('structures', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
    }

    public function testUnicode(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('unicode');
        $output = $this->getOutputData('unicode', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }

    public function testUnicodeHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('unicode');
        $output = $this->getOutputData('unicode', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
    }

    public function testValues(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('values');
        $output = $this->getOutputData('values', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }

    public function testValuesHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('values');
        $output = $this->getOutputData('values', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
    }

    public function testWeird(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('weird');
        $output = $this->getOutputData('weird', false);

        self::assertEquals($output, $instance->canonicalize($input));
    }

    public function testWeirdHex(): void
    {
        $instance = new JsonCanonicalizer();

        $input = $this->getInputData('weird');
        $output = $this->getOutputData('weird', true);

        self::assertEquals($output, $instance->canonicalizeAsHex($input));
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
