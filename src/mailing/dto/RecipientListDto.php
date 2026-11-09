<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;
use infotech\components\mailing\value\ListReference;

final readonly class RecipientListDto implements Arrayable
{
    use SerializesToArray;

    public function __construct(public ListReference $reference, public string $name)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(ListReference::fromArray($data), $data['name'] ?? null);
    }

    public function toArray(): array
    {
        return $this->reference->toArray() + ['name' => $this->name];
    }
}