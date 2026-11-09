<?php

declare(strict_types=1);

namespace infotech\components\mailing\contracts;

interface Arrayable extends \JsonSerializable
{
    public function toArray(): array;
}
