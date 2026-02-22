<?php

namespace infotech\components\clickhouse;

use yii\db\ArrayExpression;
use yii\db\ColumnSchema as BaseColumnSchema;
use yii\db\ExpressionInterface;
use yii\db\JsonExpression;
use yii\db\Schema;

class ColumnSchema extends BaseColumnSchema
{
    public int $dimension = 0;

    public function dbTypecast($value): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        if ($this->dimension) {
            return new ArrayExpression($value, $this->dbType, $this->dimension);
        }

        if ($this->dbType === Schema::TYPE_JSON) {
            return new JsonExpression($value, $this->dbType);
        }

        return $this->typecast($value);
    }

    public function phpTypecast($value)
    {
        if ($this->dimension) {
            if (!is_array($value)) {
                $value = $this->getArrayParser()->parse($value);
            }

            if (is_array($value)) {
                array_walk_recursive($value, function (&$val) {
                    $val = $this->phpTypecastValue($val);
                });
            } elseif ($value === null) {
                return null;
            }

            return $value;
        }

        return $this->phpTypecastValue($value);
    }

    protected function phpTypecastValue($value)
    {
        if ($value === null) {
            return null;
        }

        if ($this->type === Schema::TYPE_JSON) {
            return json_decode($value, true);
        }

        return parent::phpTypecast($value);
    }

    protected function getArrayParser(): ArrayParser
    {
        static $parser = null;

        if ($parser === null) {
            $parser = new ArrayParser();
        }

        return $parser;
    }
}
