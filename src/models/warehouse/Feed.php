<?php

namespace infotech\components\models\warehouse;

class Feed
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
    public const LEGO_CAR_V2 = 20;
    public const KIA_RU = 21;

    public static function getListDealers(): array
    {
        return array_intersect_key(
            static::getList(),
            array_flip([
                static::AUTO_RU,
                static::AUTO_RU_V2,
                static::AVITO,
                static::CARS_GURU,
                static::DROM_RU,
                static::EURO_PLAN,
                static::EXPERT_AVITO,
                static::LEGO_CAR,
                static::LEGO_CAR_V2,
                static::RAIFFEISEN,
                static::SBERBANK,
                static::YANDEX_DIRECT,
                static::YANDEX_XML,
            ])
        );
    }

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
            self::LEGO_CAR_V2 => 'LegoCar V2',
            self::MAXPOSTER_CLOSE => 'Автохаб (MaxPoster) - Закрывающий',
            self::MAXPOSTER => 'Автохаб (MaxPoster)',
            self::MAXPOSTER_OLD => 'Автохаб (MaxPoster) - Старая версия',
            self::SBERBANK => 'Sberbank Лизинг',
            self::RAIFFEISEN => 'Raiffeisen',
            self::YANDEX_DIRECT => 'Смарт баннеры Яндекс Директ',
            self::YANDEX_XML => 'YML',
            self::KIA_RU => 'Kia.ru',
        ];
    }
}
