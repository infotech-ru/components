<?php

namespace infotech\components\clickhouse;

use Yii;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\db\Connection;

class ActiveRecord extends BaseActiveRecord
{
    public static function getDb(): Connection
    {
        return Yii::$app->get('clickhouse');
    }
}
