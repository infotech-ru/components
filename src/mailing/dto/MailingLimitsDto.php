<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;

final readonly class MailingLimitsDto implements Arrayable
{
    use SerializesToArray;

    public function __construct(public int $maxRecipients)
    {
        if ($maxRecipients < 0) {
            throw new \InvalidArgumentException('Recipient limit cannot be negative.');
        }
    }

    public static function fromArray(array $data): self
    {
        $limit = filter_var($data['max_recipients'] ?? null, FILTER_VALIDATE_INT);
        if ($limit === false) {
            throw new \InvalidArgumentException('Recipient limit must be int');
        }

        return new self((int)$limit);
    }

    public function toArray(): array
    {
        return ['max_recipients' => $this->maxRecipients];
    }
}
