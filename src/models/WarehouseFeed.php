<?php

namespace infotech\components\models;

class WarehouseFeed
{
    public const AUTO_RU = 1;
    public const AUTO_RU_V2 = 18;
    public const AUTO_SPOT = 2;
    public const AUTO_SPOT_V2 = 17;
    public const AVITO = 3;
    public const CAR_COPY = 4;
    public const CARS_GURU = 5;
    public const CM_EXPERT = 6;
    public const DROM_RU = 7;
    public const EURO_PLAN = 8;
    public const EXPERT_AVITO = 9;
    public const LEGO_CAR = 10;
    public const MAXPOSTER_CLOSE = 11;
    public const MAXPOSTER = 12;
    public const MAXPOSTER_OLD = 19;
    public const RAIFFEISEN = 13;
    public const SBERBANK = 14;
    public const YANDEX_DIRECT = 15;
    public const YANDEX_XML = 16;

    public static function getList(): array
    {
        return [
            self::AUTO_RU => 'Auto.ru',
            self::AUTO_RU_V2 => 'Auto.ru V2',
            self::AUTO_SPOT => 'AutoSpot',
            self::AUTO_SPOT_V2 => 'AutoSpot v.2',
            self::AVITO => 'Avito',
            self::CAR_COPY => 'Car Copy',
            self::CARS_GURU => 'CarsGuru',
            self::CM_EXPERT => 'CM.Expert',
            self::DROM_RU => 'Drom.ru',
            self::EURO_PLAN => 'Европлан',
            self::EXPERT_AVITO => 'Expert Avito',
            self::LEGO_CAR => 'LegoCar',
            self::MAXPOSTER_CLOSE => 'MaxPoster - Закрывающий',
            self::MAXPOSTER => 'MaxPoster',
            self::MAXPOSTER_OLD => 'MaxPoster - Старая версия',
            self::SBERBANK => 'Sberbank Лизинг',
            self::RAIFFEISEN => 'Raiffeisen',
            self::YANDEX_DIRECT => 'Смарт баннеры Яндекс Директ',
            self::YANDEX_XML => 'YML',
        ];
    }
}
