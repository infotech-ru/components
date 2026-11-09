<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;

final readonly class MailboxDto implements Arrayable
{
    use SerializesToArray;

    public string $id;
    public array $vendorIds;

    public function __construct(string|int $id, public string $email, public string $name, array $vendorIds)
    {
        if (trim((string)$id) === '' || (is_int($id) && $id < 1)) {
            throw new \InvalidArgumentException('ID must be non-empty string or positive integer.');
        }

        $this->id = (string)$id;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !array_is_list($vendorIds) || $vendorIds === []) {
            throw new \InvalidArgumentException('Invalid mailbox.');
        }

        $normalizedIds = [];
        foreach ($vendorIds as $vendorId) {
            if (trim((string)$vendorId) === '' || (is_int($vendorId) && $vendorId < 1)) {
                throw new \InvalidArgumentException('Vendor ID must be non-empty string or positive integer.');
            }

            $normalizedIds[] = (string)$vendorId;
        }

        $this->vendorIds = array_values(array_unique($normalizedIds));
    }

    public static function fromArray(array $data): self
    {
        if (!is_array($data['vendor_ids'] ?? null)) {
            throw new \InvalidArgumentException('Expected vendor IDs.');
        }
        return new self(
            $data['id'] ?? null,
            $data['email'] ?? null,
            $data['name'] ?? null,
            $data['vendor_ids'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'vendor_ids' => $this->vendorIds,
        ];
    }
}
