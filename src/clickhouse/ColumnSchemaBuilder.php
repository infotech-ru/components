<?php

namespace infotech\components\clickhouse;

use yii\db\mysql\ColumnSchemaBuilder as MySqlColumnSchemaBuilder;
use yii\db\Schema;

class ColumnSchemaBuilder extends MySqlColumnSchemaBuilder
{
    public static $typeCategoryMap = [
        Schema::TYPE_CHAR => self::CATEGORY_STRING,
        Schema::TYPE_STRING => self::CATEGORY_STRING,
        Schema::TYPE_TEXT => self::CATEGORY_STRING,
        Schema::TYPE_TINYINT => self::CATEGORY_NUMERIC,
        Schema::TYPE_SMALLINT => self::CATEGORY_NUMERIC,
        Schema::TYPE_INTEGER => self::CATEGORY_NUMERIC,
        Schema::TYPE_BIGINT => self::CATEGORY_NUMERIC,
        Schema::TYPE_FLOAT => self::CATEGORY_NUMERIC,
        Schema::TYPE_DOUBLE => self::CATEGORY_NUMERIC,
        Schema::TYPE_DECIMAL => self::CATEGORY_NUMERIC,
        Schema::TYPE_DATETIME => self::CATEGORY_TIME,
        Schema::TYPE_DATE => self::CATEGORY_TIME,
        Schema::TYPE_BOOLEAN => self::CATEGORY_NUMERIC,
    ];

    public function __toString()
    {
        if (Schema::TYPE_CHAR === $this->type) {
            return $this->buildCompleteString('{type}{length}{default}');
        }

        $format = match ($this->getTypeCategory()) {
            self::CATEGORY_NUMERIC => '{unsigned}{type}{default}',
            default => '{type}{default}',
        };

        return $this->buildCompleteString($format);
    }

    protected function buildUnsignedString(): string
    {
        return $this->isUnsigned ? 'U' : '';
    }

    protected function buildNotNullString(): string
    {
        return $this->isNotNull === true ? ' NOT NULL' : '';
    }

    protected function buildCompleteString($format): string
    {
        $type = $this->db->queryBuilder->typeMap[$this->type] ?? $this->type;

        $placeholderValues = [
            '{type}' => $this->isNotNull === false ? "Nullable($type)" : $type,
            '{length}' => $this->buildLengthString(),
            '{unsigned}' => $this->buildUnsignedString(),
            '{notnull}' => $this->buildNotNullString(),
            '{unique}' => $this->buildUniqueString(),
            '{default}' => $this->buildDefaultString(),
            '{check}' => $this->buildCheckString(),
            '{comment}' => $this->buildCommentString(),
            '{pos}' => $this->isFirst ? $this->buildFirstString() : $this->buildAfterString(),
            '{append}' => $this->buildAppendString(),
        ];

        return strtr($format, $placeholderValues);
    }
}
