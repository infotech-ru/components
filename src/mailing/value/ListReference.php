<?php

declare(strict_types=1);

namespace infotech\components\mailing\value;

use infotech\components\mailing\contracts\Arrayable;
use infotech\components\mailing\dto\SerializesToArray;
use infotech\components\mailing\enums\ListType;

final readonly class ListReference implements Arrayable
{
    use SerializesToArray;

    public string $id;

    public function __construct(string|int $id, public ListType $type)
    {
        if (trim((string)$id) === '' || (is_int($id) && $id < 1)) {
            throw new \InvalidArgumentException('ID must be non-empty string or positive integer.');
        }

        $this->id = (string)$id;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'] ?? null, ListType::from($data['type'] ?? null));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->value,
        ];
    }
}