<?php

namespace infotech\components\models;

class Tariff
{
    public const int TARIFF_1 = 1;
    public const int TARIFF_2 = 2;

    public static function getTariffLimit(): array
    {
        return [
            self::TARIFF_1 => 600,
            self::TARIFF_2 => 1200,
        ];
    }

    public static function getTariffList(): array
    {
        return [
            self::TARIFF_1 => 'Тариф 1',
            self::TARIFF_2 => 'Тариф 2',
        ];
    }
}
