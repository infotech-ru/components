<?php

namespace infotech\components\helpers;

final class ArrayHelper
{
    /**
     * Вычисляет глубину многомерного массива
     *
     * @param array $array
     * @return int
     */
    public static function depth(array $array): int
    {
        static $depth;

        $depth ??= 1;

        if (self::arrayIn($array)) {
            $depth++;
            foreach ($array as $value) {
                if (is_array($value) && self::arrayIn($value)) {
                    self::depth($value);
                }
            }
        }

        return $depth;
    }

    /**
     * @param array $array
     * @return bool
     */
    protected static function arrayIn(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Сведение многомерного массива в один уровень
     *
     * @param array $array
     * @param int   $depth
     * @return array
     */
    public static function flatten(array $array, int $depth = INF): array
    {
        $result = [];

        foreach ($array as $item) {
            if (is_array($item)) {
                if ($depth === 1) {
                    $result = array_merge($result, $item);
                    continue;
                }

                $result = array_merge($result, static::flatten($item, $depth - 1));
                continue;
            }

            $result[] = $item;
        }

        return $result;
    }
}
