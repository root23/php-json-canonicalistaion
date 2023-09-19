<?php

declare(strict_types=1);

namespace Root23\JsonCanonicalizator;

class JsonCanonicalizator implements JsonCanonicalizatorInterface
{
    public const JSON_FLAGS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    public const ENCODING = 'UTF-16BE';

    public function canonicalize(mixed $data, bool $asHex): string
    {
        ob_start();

        $this->serialize($data);

        $result = ob_get_clean();

        return $asHex ? Helpers::asHex($result) : $result;
    }

    private function serialize($item)
    {
        if (is_float($item)) {
            echo Helpers::es6NumberFormat($item);

            return;
        }

        if (is_null($item) || is_scalar($item)) {
            echo json_encode($item, self::JSON_FLAGS);

            return;
        }

        if (is_array($item) && !Helpers::isArrayAssoc($item)) {
            echo '[';
            $next = false;
            foreach ($item as $element) {
                if ($next) {
                    echo ',';
                }
                $next = true;
                $this->serialize($element);
            }
            echo ']';

            return;
        }

        if (is_object($item)) {
            $item = (array)$item;
        }

        uksort($item, static function (string $a, string $b) {
            $a = mb_convert_encoding($a, self::ENCODING);
            $b = mb_convert_encoding($b, self::ENCODING);

            return strcmp($a, $b);
        });

        echo '{';
        $next = false;
        foreach ($item as $key => $value) {
            if ($next) {
                echo ',';
            }
            $next = true;
            $outKey = json_encode((string)$key, self::JSON_FLAGS);
            echo $outKey, ':', $this->serialize($value);
        }
        echo '}';
    }
}
