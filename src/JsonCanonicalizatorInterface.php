<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizator;

interface JsonCanonicalizatorInterface
{
    public function canonicalize($data, bool $asHex): string;
}
