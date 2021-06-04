<?php

namespace infotech\components\models;

class WarehouseFeed
{
    public const AUTO_RU = 1;
    public const AUTO_SPOT = 2;
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
    public const RAIFFEISEN = 13;
    public const SBERBANK = 14;
    public const YANDEX_DIRECT = 15;
    public const YANDEX_XML = 16;

    public static function getList(): array
    {
        return [
            self::AUTO_RU => 'AutoRu',
            self::AUTO_SPOT => 'AutoSpot',
            self::AVITO => 'Avito',
            self::CAR_COPY => 'CarCopy',
            self::CARS_GURU => 'CarsGuru',
            self::CM_EXPERT => 'CmExpert',
            self::DROM_RU => 'DromRu',
            self::EURO_PLAN => 'EuroPlan',
            self::EXPERT_AVITO => 'ExpertAvito',
            self::LEGO_CAR => 'LegoCar',
            self::MAXPOSTER_CLOSE => 'MaxposterClose',
            self::MAXPOSTER => 'Maxposter',
            self::RAIFFEISEN => 'Raiffeisen',
            self::SBERBANK => 'Sberbank',
            self::YANDEX_DIRECT => 'YandexDirect',
            self::YANDEX_XML => 'YandexXml',
        ];
    }
}
