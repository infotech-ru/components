<?php

namespace infotech\components\clickhouse;

class ArrayParser
{
    public function parse(mixed $value): ?array
    {
        if (is_array($value) || is_null($value)) {
            return $value;
        } elseif (!is_string($value)) {
            return null;
        }

        if ($value === '[]') {
            return [];
        }

        $jsonDecoded = json_decode($value, true);

        if (is_array($jsonDecoded)) {
            return $jsonDecoded;
        }

        if (preg_match('/^\[(.+)]$/iu', $value, $matches)) {
            return array_map(
                static fn(mixed $v): mixed => ($v === 'NULL' || $v === 'null') ? null : $v,
                str_getcsv($matches[1], ',', "'"),
            );
        }

        return null;
    }
}
