<?php

namespace infotech\components\clickhouse;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * @property-read string $alias
 * @property-read string $tableName
 *
 * @method ?ActiveRecord one($db = null)
 * @method ActiveRecord[] all($db = null)
 *
 * @see ActiveRecord
 */
class BaseActiveQuery extends \yii\db\ActiveQuery
{
    private $_alias;

    public static function fullQuoteFieldName(string $alias, string $name): string
    {
        return "$alias.[[$name]]";
    }

    public function init(): void
    {
        $this->alias($this->getPrimaryTableName());

        parent::init();
    }

    public function alias($alias): static
    {
        $this->_alias = $alias;

        return parent::alias($alias);
    }

    public function getAlias(): string
    {
        return $this->_alias;
    }

    public function getTableName()
    {
        return $this->_alias;
    }

    public function fullQuoteField(string $name): string
    {
        return self::fullQuoteFieldName($this->_alias, $name);
    }

    public function byID(
        array|Expression|ActiveQuery|int|string|null $id,
        bool $search = false,
        bool $not = false
    ): static {
        return $this->byField('id', $id, $not, $search);
    }

    public function andExists(Query $query): static
    {
        return $this->andWhere(['EXISTS', $query]);
    }

    protected function byField(
        string $field,
        int|string|array|Expression|ActiveQuery|null $value,
        bool $not = false,
        bool $search = false
    ): static {
        $condition = [$this->fullQuoteField($field) => $search ? $this->split($value) : $value];

        if ($not) {
            $condition = ['NOT', $condition];
        }

        return $search ? $this->andFilterWhere($condition) : $this->andOnCondition($condition);
    }

    private function split($value)
    {
        return is_string($value) && trim($value) !== '' ? array_filter(preg_split('/\s*[;,\s\n]\s*/', $value)) : $value;
    }
}
