<?php

namespace infotech\components\clickhouse;

use Traversable;
use yii\db\ArrayExpression;
use yii\db\Expression;
use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionBuilderTrait;
use yii\db\ExpressionInterface;
use yii\db\JsonExpression;
use yii\db\Query;
use yii\db\Schema;

class ArrayExpressionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;

    public function build(ExpressionInterface $expression, array &$params = []): string
    {
        /** @var ArrayExpression $expression */
        $value = $expression->getValue();

        if ($value === null) {
            return 'NULL';
        }

        if ($value instanceof Query) {
            [$sql, $params] = $this->queryBuilder->build($value, $params);
            return $this->buildSubqueryArray($sql);
        }

        $placeholders = $this->buildPlaceholders($expression, $params);

        return '[' . implode(', ', $placeholders) . ']';
    }

    protected function buildPlaceholders(ArrayExpression $expression, array &$params): array
    {
        $value = $expression->getValue();

        $placeholders = [];

        if ($value === null || (!is_array($value) && !$value instanceof Traversable)) {
            return $placeholders;
        }

        if ($expression->getDimension() > 1) {
            foreach ($value as $item) {
                $placeholders[] = $this->build($this->unnestArrayExpression($expression, $item), $params);
            }

            return $placeholders;
        }

        foreach ($value as $item) {
            if ($item instanceof Query) {
                [$sql, $params] = $this->queryBuilder->build($item, $params);
                $placeholders[] = $this->buildSubqueryArray($sql);
                continue;
            }

            $item = $this->typecastValue($expression, $item);

            if ($item instanceof ExpressionInterface) {
                $placeholders[] = $this->queryBuilder->buildExpression($item, $params);
                continue;
            }

            $placeholders[] = $this->queryBuilder->bindParam($item, $params);
        }

        return $placeholders;
    }

    private function unnestArrayExpression(ArrayExpression $expression, mixed $value): ArrayExpression
    {
        $expressionClass = get_class($expression);

        return new $expressionClass($value, $expression->getType(), $expression->getDimension() - 1);
    }

    protected function buildSubqueryArray($sql): string
    {
        return '[' . $sql . ']';
    }

    protected function typecastValue(ArrayExpression $expression, mixed $value): mixed
    {
        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        if (str_starts_with($expression->getType(), 'Tuple')) {
            $json = json_encode($value, JSON_UNESCAPED_UNICODE);
            $jsonKey = ':json_' . md5($json);

            return new Expression("JSONExtract({$jsonKey}, '"  . $expression->getType() . "')", [$jsonKey => $json]);
        }

        if ($expression->getType() === Schema::TYPE_JSON) {
            return new JsonExpression($value);
        }

        return $value;
    }
}
