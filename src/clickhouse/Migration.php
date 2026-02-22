<?php

namespace infotech\components\clickhouse;

use yii\db\ColumnSchemaBuilder as BaseColumnSchemaBuilder;
use yii\db\Migration as BaseMigration;

class Migration extends BaseMigration
{
    public $db = 'clickhouse';

    public function createDictionary($dictionary, $columns, $options = null): void
    {
        $time = $this->beginCommand("create dictionary $dictionary");
        $this->db->createCommand()->createDictionary($dictionary, $columns, $options)->execute();

        foreach ($columns as $column => $type) {
            if ($type instanceof ColumnSchemaBuilder && $type->comment !== null) {
                $this->db->createCommand()->addCommentOnColumn($dictionary, $column, $type->comment)->execute();
            }
        }

        $this->endCommand($time);
    }

    public function dateTime64(?int $precision = null): BaseColumnSchemaBuilder
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_DATETIME_64, $precision);
    }
}
