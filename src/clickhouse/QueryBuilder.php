<?php

namespace infotech\components\clickhouse;

use yii\db\ArrayExpression;
use yii\db\ExpressionInterface;
use yii\db\QueryBuilder as BaseQueryBuilder;
use yii\db\Schema as DbSchema;
use yii\helpers\StringHelper;

class QueryBuilder extends BaseQueryBuilder
{
    public $typeMap = [
        DbSchema::TYPE_CHAR => 'FixedString',
        DbSchema::TYPE_STRING => 'String',
        DbSchema::TYPE_TEXT => 'String',
        DbSchema::TYPE_TINYINT => 'Int8',
        DbSchema::TYPE_SMALLINT => 'Int16',
        DbSchema::TYPE_INTEGER => 'Int32',
        DbSchema::TYPE_BIGINT => 'Int64',
        DbSchema::TYPE_FLOAT => 'Float32',
        DbSchema::TYPE_DOUBLE => 'Float64',
        DbSchema::TYPE_DECIMAL => 'Float32',
        DbSchema::TYPE_DATETIME => 'DateTime',
        Schema::TYPE_DATETIME_64 => 'DateTime64',
        DbSchema::TYPE_TIME => 'DateTime',
        DbSchema::TYPE_DATE => 'Date',
        DbSchema::TYPE_BINARY => 'String',
        DbSchema::TYPE_BOOLEAN => 'Bool',
        DbSchema::TYPE_MONEY => 'Float32',
        DbSchema::TYPE_JSON => 'Json',
    ];

    protected function defaultExpressionBuilders(): array
    {
        return array_merge(parent::defaultExpressionBuilders(), [
            ArrayExpression::class => ArrayExpressionBuilder::class,
        ]);
    }

    public function update($table, $columns, $condition, &$params): string
    {
        [$lines, $params] = $this->prepareUpdateSets($table, $columns, $params);
        $sql = 'ALTER TABLE ' . $this->db->quoteTableName($table) . ' UPDATE ' . implode(', ', $lines);
        $where = $this->buildWhere($condition, $params);

        return $where === '' ? $sql : $sql . ' ' . $where;
    }

    public function delete($table, $condition, &$params): string
    {
        $sql = 'DELETE FROM ' . $this->db->quoteTableName($table);
        $where = $this->buildWhere($condition, $params);

        return $where === '' ? $sql : $sql . ' ' . $where . ' SETTINGS allow_experimental_lightweight_delete=1';
    }

    public function addColumn($table, $column, $type)
    {
        return 'ALTER TABLE ' . $this->db->quoteTableName($table)
            . ' ADD COLUMN ' . $this->db->quoteColumnName($column) . ' '
            . $this->getColumnType($type);
    }

    public function createDictionary($dictionary, $columns, $options = null): string
    {
        $cols = [];

        foreach ($columns as $name => $type) {
            if (is_string($name)) {
                $cols[] = "\t" . $this->db->quoteColumnName($name) . ' ' . $this->getColumnType($type);
            } else {
                $cols[] = "\t" . $type;
            }
        }

        $sql = 'CREATE DICTIONARY ' . $this->db->quoteTableName($dictionary) . " (\n" . implode(",\n", $cols) . "\n)";

        return $options === null ? $sql : $sql . ' ' . $options;
    }

    private function prepareValue($value, DbSchema $schema, &$params = []): ?string
    {
        if (is_string($value)) {
            return $schema->quoteValue($value);
        }

        if (is_float($value)) {
            // ensure type cast always has . as decimal separator in all locales
            return StringHelper::floatToString($value);
        }

        if ($value === false) {
            return 0;
        }

        if ($value === null) {
            return 'NULL';
        }

        if ($value instanceof ExpressionInterface) {
            return $this->buildExpression($value, $params);
        }

        return $value;
    }

    public function batchInsert($table, $columns, $rows, &$params = []): string
    {
        if (empty($rows)) {
            return '';
        }

        $schema = $this->db->getSchema();

        if (($tableSchema = $schema->getTableSchema($table)) !== null) {
            $columnSchemas = $tableSchema->columns;
        } else {
            $columnSchemas = [];
        }

        $values = [];

        foreach ($rows as $row) {
            $vs = [];

            foreach ($row as $i => $value) {
                if (isset($columns[$i], $columnSchemas[$columns[$i]])) {
                    $value = $columnSchemas[$columns[$i]]->dbTypecast($value);
                }

                $value = $this->prepareValue($value, $schema, $params);
                $vs[] = $value;
            }

            $values[] = '(' . implode(', ', $vs) . ')';
        }

        if (empty($values)) {
            return '';
        }

        foreach ($columns as $i => $name) {
            $columns[$i] = $schema->quoteColumnName($name);
        }

        return 'INSERT INTO ' . $schema->quoteTableName($table)
            . ' (' . implode(', ', $columns) . ') SETTINGS max_partitions_per_insert_block=1000 VALUES ' . implode(', ', $values);
    }

    public function build($query, $params = []): array
    {
        $isFinal = $query instanceof ActiveQuery && $query->isFinal();

        $query = $query->prepare($this);

        $params = empty($params) ? $query->params : array_merge($params, $query->params);

        $clauses = [
            $this->buildSelect($query->select, $params, $query->distinct, $query->selectOption),
            $this->buildFrom($query->from, $params, $isFinal),
            $this->buildJoin($query->join, $params),
            $this->buildWhere($query->where, $params),
            $this->buildGroupBy($query->groupBy),
            $this->buildHaving($query->having, $params),
        ];

        $sql = implode($this->separator, array_filter($clauses));
        $sql = $this->buildOrderByAndLimit($sql, $query->orderBy, $query->limit, $query->offset);

        if (!empty($query->orderBy)) {
            foreach ($query->orderBy as $expression) {
                if ($expression instanceof ExpressionInterface) {
                    $this->buildExpression($expression, $params);
                }
            }
        }
        if (!empty($query->groupBy)) {
            foreach ($query->groupBy as $expression) {
                if ($expression instanceof ExpressionInterface) {
                    $this->buildExpression($expression, $params);
                }
            }
        }

        $union = $this->buildUnion($query->union, $params);

        if ($union !== '') {
            $sql = "($sql){$this->separator}$union";
        }

        $with = $this->buildWithQueries($query->withQueries, $params);

        if ($with !== '') {
            $sql = "$with{$this->separator}$sql";
        }

        return [$sql, $params];
    }

    public function buildFrom($tables, &$params, bool $isFinal = false): string
    {
        return parent::buildFrom($tables, $params) . ($isFinal ? ' FINAL' : '');
    }
}
