<?php

namespace infotech\components\clickhouse;

use Closure;
use Exception;
use Yii;
use yii\db\Command as BaseCommand;
use yii\db\Exception as DbException;

class Command extends BaseCommand
{
    private Closure|array|null $_retryHandler = null;

    public function init(): void
    {
        parent::init();
        $this->_retryHandler = [$this, 'retryHandler'];
    }

    private function retryHandler(DbException $exception, int $attempt): bool
    {
        if ($attempt > 1) {
            return false;
        }

        if ($exception->errorInfo[1] === 2006) {
            $this->db->close();
            $this->db->open();

            $this->cancel();

            $pdo = $this->db->getMasterPdo();

            if ($pdo) {
                $this->pdoStatement = $pdo->prepare($this->getRawSql());
            }

            return true;
        }

        return false;
    }

    protected function internalExecute($rawSql): void
    {
        $attempt = 0;

        while (true) {
            try {
                ++$attempt;
                $this->pdoStatement->execute();
                [,$code,$message] = $this->pdoStatement->errorInfo();

                if ($code) {
                    throw new Exception($message);
                }

                break;
            } catch (Exception $e) {
                $rawSql = $rawSql ?: $this->getRawSql();
                $e = $this->db->getSchema()->convertException($e, $rawSql);

                if ($this->_retryHandler === null || !call_user_func($this->_retryHandler, $e, $attempt)) {
                    throw $e;
                }
            }
        }

        if (!YII_DEBUG && Yii::$app->has('dogstat') && ($dogstat = $this->db->dogstat ?? null)) {
            Yii::$app->dogstat->increment($dogstat);
        }
    }

    public function createDictionary($dictionary, $columns, $options = null): Command
    {
        $sql = $this->db->getQueryBuilder()->createDictionary($dictionary, $columns, $options);

        return $this->setSql($sql)->requireTableSchemaRefresh($dictionary);
    }
}
