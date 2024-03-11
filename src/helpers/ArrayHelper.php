<?php

namespace infotech\components\helpers;

final class ArrayHelper
{
    /**
     * Вычисляет глубину многомерного массива
     */
    public static function maxDepth(array $array): int
    {
        $maxDepth = 0;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = self::maxDepth($value) + 1;
                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }

        return $maxDepth;
    }

    /**
     * Сведение многомерного массива в один уровень
     */
    public static function flatten(array $array, $depth = INF, bool $keepKeys = false): array
    {
        $result = [];

        foreach ($array as $key => $item) {
            if (is_array($item)) {
                if ($depth === 1) {
                    $result = array_merge($result, $item);
                    continue;
                }

                $result = array_merge($result, self::flatten($item, $depth - 1, $keepKeys));
                continue;
            }

            if ($keepKeys) {
                $result[$key] = $item;
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }
}
