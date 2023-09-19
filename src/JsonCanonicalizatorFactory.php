<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizator;

class JsonCanonicalizatorFactory
{
    public static function getInstance(): JsonCanonicalizator
    {
        return new JsonCanonicalizator();
    }
}
