<?php

namespace infotech\components\models\warehouse;

use Yii;

class FeedPlace
{
    public const PLACE_BEFORE = 1;
    public const PLACE_AFTER = 2;


    public static function getPlaceList(): array
    {
        return [
            self::PLACE_BEFORE => Yii::t('infotech-components', 'До описания а/м'),
            self::PLACE_AFTER => Yii::t('infotech-components', 'После описания а/м'),
        ];
    }
}
