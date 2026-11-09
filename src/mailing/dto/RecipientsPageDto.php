<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;

final readonly class RecipientsPageDto implements Arrayable
{
    use SerializesToArray;

    public function __construct(public array $items, public ?string $nextCursor = null)
    {
        if (!array_is_list($items) || ($nextCursor !== null && trim($nextCursor) === '')) {
            throw new \InvalidArgumentException('Invalid recipient page.');
        }
        foreach ($items as $item) {
            if (!$item instanceof RecipientDto) {
                throw new \InvalidArgumentException('Expected RecipientDto.');
            }
        }
    }

    public static function fromArray(array $data): self
    {
        $cursor = $data['next_cursor'] ?? null;
        if ($cursor !== null && !is_string($cursor)) {
            throw new \InvalidArgumentException('Invalid cursor.');
        }
        $items = $data['items'] ?? null;
        if (!is_array($items) || !array_is_list($items)) {
            throw new \InvalidArgumentException('Recipient page items must be a JSON array.');
        }

        $recipients = [];
        foreach ($items as $item) {
            $recipients[] = RecipientDto::fromArray($item);
        }

        return new self($recipients, $cursor);
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(static fn (RecipientDto $item) => $item->toArray(), $this->items),
            'next_cursor' => $this->nextCursor,
        ];
    }
}
