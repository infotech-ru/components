<?php

namespace infotech\components\clickhouse;

class ActiveQuery extends BaseActiveQuery
{
    private bool $final = false;

    public function final(): self
    {
        $this->final = true;
        return $this;
    }

    public function isFinal(): bool
    {
        return $this->final;
    }
}
