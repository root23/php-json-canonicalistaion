<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizer;

final class JsonCanonicalizer implements JsonCanonicalizerInterface
{
    use ArrayHelperTrait;

    public const JSON_FLAGS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    public const ENCODING = 'UTF-16BE';

    /**
     * @throws \JsonException
     */
    public function canonicalize($data): string
    {
        return $this->encode($data);
    }

    /**
     * @throws \JsonException
     */
    public function canonicalizeAsHex($data): string
    {
        return Converter::toHex($this->encode($data));
    }

    /**
     * @throws \JsonException
     */
    private function encode($item): bool|string
    {
        if (is_float($item)) {
            return Converter::toEs6NumberFormat($item);
        }

        if (is_null($item) || is_scalar($item)) {
            return json_encode($item, JSON_THROW_ON_ERROR | self::JSON_FLAGS);
        }

        if (is_array($item) && !self::isArrayAssoc($item)) {
            $result = '[';

            $next = false;
            foreach ($item as $element) {
                if ($next) {
                    $result .= ',';
                }
                $next = true;
                $result .= $this->encode($element);
            }
            $result .= ']';

            return $result;
        }

        if (is_object($item)) {
            $item = (array)$item;
        }

        uksort($item, static function (string $a, string $b) {
            $a = mb_convert_encoding($a, self::ENCODING);
            $b = mb_convert_encoding($b, self::ENCODING);

            return strcmp($a, $b);
        });

        $str = '{';
        $next = false;
        foreach ($item as $key => $value) {
            if ($next) {
                $str .= ',';
            }
            $next = true;
            $outKey = json_encode((string)$key, JSON_THROW_ON_ERROR | self::JSON_FLAGS);
            $str .= $outKey . ':' . $this->encode($value);
        }
        $str .= '}';

        return $str;
    }
}
