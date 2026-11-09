<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

trait SerializesToArray
{
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
