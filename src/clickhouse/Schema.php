<?php

namespace infotech\components\clickhouse;

use Exception;
use PDO;
use PDOException;
use yii\db\ColumnSchema as BaseColumnSchema;
use yii\db\Expression;
use yii\db\mysql\Schema as MySqlSchema;
use yii\db\TableSchema;

class Schema extends MySqlSchema
{
    public const string TYPE_DATETIME_64 = 'datetime64';

    public $typeMap = [
        'UInt8' => self::TYPE_TINYINT,
        'UInt16' => self::TYPE_SMALLINT,
        'UInt32' => self::TYPE_INTEGER,
        'UInt64' => self::TYPE_BIGINT,
        'UInt128' => self::TYPE_BIGINT,
        'UInt256' => self::TYPE_BIGINT,
        'Int8' => self::TYPE_TINYINT,
        'Int16' => self::TYPE_SMALLINT,
        'Int32' => self::TYPE_INTEGER,
        'Int64' => self::TYPE_BIGINT,
        'Int128' => self::TYPE_BIGINT,
        'Int256' => self::TYPE_BIGINT,
        'Float32' => self::TYPE_FLOAT,
        'Float64' => self::TYPE_DOUBLE,
        'Decimal' => self::TYPE_DECIMAL,
        'Decimal32' => self::TYPE_DECIMAL,
        'Decimal64' => self::TYPE_DECIMAL,
        'Decimal128' => self::TYPE_DECIMAL,
        'Decimal256' => self::TYPE_DECIMAL,
        'String' => self::TYPE_STRING,
        'FixedString' => self::TYPE_CHAR,
        'Bool' => self::TYPE_BOOLEAN,
        'UUID' => self::TYPE_STRING,
        'Date' => self::TYPE_DATE,
        'Date32' => self::TYPE_DATE,
        'DateTime' => self::TYPE_DATETIME,
        'DateTime64' => self::TYPE_DATETIME_64,
        'Enum8' => self::TYPE_STRING,
        'Enum16' => self::TYPE_STRING,
        'Json' => self::TYPE_JSON,
    ];

    public $columnSchemaClass = ColumnSchema::class;

    protected $tableQuoteCharacter = "`";

    protected function loadTableSchema($name): ?TableSchema
    {
        $table = new TableSchema();
        $this->resolveTableNames($table, $name);

        if ($this->findColumns($table)) {
            return $table;
        }

        return null;
    }

    protected function findColumns($table): bool
    {
        $sql = 'DESCRIBE TABLE ' . $this->quoteTableName($table->fullName);

        try {
            $columns = $this->db->createCommand($sql)->queryAll();
        } catch (Exception $e) {
            $previous = $e->getPrevious();

            if ($previous instanceof PDOException && str_contains($previous->getMessage(), 'SQLSTATE[42S02')) {
                return false;
            }

            throw $e;
        }

        foreach ($columns as $info) {
            if ($this->db->slavePdo->getAttribute(PDO::ATTR_CASE) !== PDO::CASE_LOWER) {
                $info = array_change_key_case($info);
            }

            $column = $this->loadColumnSchema($info);
            $table->columns[$column->name] = $column;

            if ($column->isPrimaryKey) {
                $table->primaryKey[] = $column->name;

                if ($column->autoIncrement) {
                    $table->sequenceName = '';
                }
            }
        }

        return true;
    }

    protected function loadColumnSchema($info): BaseColumnSchema
    {
        /** @var ColumnSchema $column */
        $column = $this->createColumnSchema();

        while (str_starts_with($info['type'], 'Array')) {
            $column->dimension++;
            $info['type'] = substr($info['type'], 6, -1);
        }

        $column->name = $info['name'];
        $column->allowNull = str_starts_with($info['type'], 'Nullable');
        $column->isPrimaryKey = false;
        $column->autoIncrement = false;
        $column->comment = $info['comment'];
        $column->dbType = $info['type'];

        if ($column->allowNull) {
            $column->dbType = substr($column->dbType, 9, -1);
        }

        $column->unsigned = stripos($column->dbType, 'UInt') !== false;
        $column->type = self::TYPE_STRING;

        if (preg_match('/^(\w+)(?:\(([^)]+)\))?/', $column->dbType, $matches)) {
            $type = $matches[1];

            if (isset($this->typeMap[$type])) {
                $column->type = $this->typeMap[$type];
            }

            if (!empty($matches[2])) {
                if ($type === 'Enum8' || $type === 'Enum16') {
                    preg_match_all("/'[^']*'/", $matches[2], $values);
                    foreach ($values[0] as $i => $value) {
                        $values[$i] = trim($value, "'");
                    }
                    $column->enumValues = $values;
                } else {
                    $values = explode(',', $matches[2]);
                    $column->size = $column->precision = (int) $values[0];
                    if (isset($values[1])) {
                        $column->scale = (int) $values[1];
                    }
                }
            }
        }

        $column->phpType = $this->getColumnPhpType($column);

        if ($info['default_expression']) {
            if (
                in_array($column->type, ['Date', 'Date32', 'DateTime', 'DateTime64'])
                && isset($info['default'])
                && preg_match('/^current_timestamp(?:\(([0-9]*)\))?$/i', $info['default'], $matches)
            ) {
                $column->defaultValue = new Expression('CURRENT_TIMESTAMP' . (!empty($matches[1]) ? '(' . $matches[1] . ')' : ''));
            } else {
                $column->defaultValue = $column->phpTypecast($info['default_expression']);
            }
        }

        return $column;
    }

    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->db);
    }

    public function createColumnSchemaBuilder($type, $length = null): ColumnSchemaBuilder
    {
        return new ColumnSchemaBuilder($type, $length, $this->db);
    }
}
