<?php

namespace infotech\components\models;

use Yii;

class Service
{
    public const SERVICE_ALL_SALE_FRESH = 1;
    public const SERVICE_ALL_SALE_PREMIUM = 2;
    public const SERVICE_ALL_SALE_SPECIAL = 3;
    public const SERVICE_ALL_SALE_BADGE = 4;
    public const SERVICE_PACKAGE_TURBO = 5;
    public const SERVICE_ALL_SALE_ACTIVATE = 6;
    public const SERVICE_AVITO_X2_1 = 7;
    public const SERVICE_AVITO_X5_1 = 9;
    public const SERVICE_AVITO_X10_7 = 12;
    public const SERVICE_AVITO_X2_7 = 8;
    public const SERVICE_AVITO_X5_7 = 10;
    public const SERVICE_AVITO_X10_1 = 11;
    public const SERVICE_AVITO_HIGHLIGHT = 13;
    public const SERVICE_AVITO_XL = 14;

    public static function getServiceListCss(): array
    {
        return [
            self::SERVICE_ALL_SALE_FRESH => 'service-all-sale-fresh',
            self::SERVICE_ALL_SALE_PREMIUM => 'service-all-sale-premium',
            self::SERVICE_ALL_SALE_SPECIAL => 'service-all-sale-special',
            self::SERVICE_ALL_SALE_BADGE => 'service-all-sale-badge',
            self::SERVICE_PACKAGE_TURBO => 'service-package-turbo',
            self::SERVICE_ALL_SALE_ACTIVATE => 'service-all-sale-activate',

            self::SERVICE_AVITO_X2_1 => 'service-avito-x21',
            self::SERVICE_AVITO_X5_1 => 'service-avito-x51',
            self::SERVICE_AVITO_X10_1 => 'service-avito-x101',
            self::SERVICE_AVITO_X2_7 => 'service-avito-x27',
            self::SERVICE_AVITO_X5_7 => 'service-avito-x57',
            self::SERVICE_AVITO_X10_7 => 'service-avito-x107',
            self::SERVICE_AVITO_HIGHLIGHT => 'service-avito-highlight',
            self::SERVICE_AVITO_XL => 'service-avito-xl',
        ];
    }

    public static function getServiceList(): array
    {
        return [
            self::SERVICE_ALL_SALE_FRESH => Yii::t('infotech-components', 'Поднятие объявления в поиске'),
            self::SERVICE_ALL_SALE_PREMIUM => Yii::t('infotech-components', 'Премиум'),
            self::SERVICE_ALL_SALE_SPECIAL => Yii::t('infotech-components', 'Спецпредложение'),
            self::SERVICE_ALL_SALE_BADGE => Yii::t('infotech-components', 'Стикеры быстрой продажи'),
            self::SERVICE_PACKAGE_TURBO => Yii::t('infotech-components', 'Турбо-продажа'),
            self::SERVICE_ALL_SALE_ACTIVATE => Yii::t('infotech-components', 'Активация'),

            self::SERVICE_AVITO_X2_1 => Yii::t('infotech-components', 'До 2 раз больше просмотров на 1 день'),
            self::SERVICE_AVITO_X5_1 => Yii::t('infotech-components', 'До 5 раз больше просмотров на 1 день'),
            self::SERVICE_AVITO_X10_1 => Yii::t('infotech-components', 'До 10 раз больше просмотров на 1 день'),
            self::SERVICE_AVITO_X2_7 => Yii::t('infotech-components', 'До 2 раз больше просмотров на 7 день'),
            self::SERVICE_AVITO_X5_7 => Yii::t('infotech-components', 'До 5 раз больше просмотров на 7 день'),
            self::SERVICE_AVITO_X10_7 => Yii::t('infotech-components', 'До 10 раз больше просмотров на 7 день'),
            self::SERVICE_AVITO_HIGHLIGHT => Yii::t('infotech-components', 'Выделение объявления'),
            self::SERVICE_AVITO_XL => Yii::t('infotech-components', 'XL-объявление'),
        ];
    }

    public static function getServiceExtName(): array
    {
        return [
            self::SERVICE_ALL_SALE_FRESH => 'all_sale_fresh',
            self::SERVICE_ALL_SALE_PREMIUM => 'all_sale_premium',
            self::SERVICE_ALL_SALE_SPECIAL => 'all_sale_special',
            self::SERVICE_ALL_SALE_BADGE => 'all_sale_badge',
            self::SERVICE_PACKAGE_TURBO => 'package_turbo',
            self::SERVICE_ALL_SALE_ACTIVATE => 'all_sale_activate',

            self::SERVICE_AVITO_X2_1 => 'x2_1',
            self::SERVICE_AVITO_X5_1 => 'x5_1',
            self::SERVICE_AVITO_X10_1 => 'x10_1',
            self::SERVICE_AVITO_X2_7 => 'x2_7',
            self::SERVICE_AVITO_X5_7 => 'x5_7',
            self::SERVICE_AVITO_X10_7 => 'x10_7',
            self::SERVICE_AVITO_HIGHLIGHT => 'highlight',
            self::SERVICE_AVITO_XL => 'xl',
        ];
    }

}
