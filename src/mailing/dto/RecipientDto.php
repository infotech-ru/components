<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;
use infotech\components\mailing\enums\Gender;

final readonly class RecipientDto implements Arrayable
{
    use SerializesToArray;

    public string $clientId;

    public function __construct(
        string|int $clientId,
        public string $email,
        public string $fullName,
        public ?Gender $gender = null,
        public array $variables = [],
    ) {
        if (trim((string)$clientId) === '' || (is_int($clientId) && $clientId < 1)) {
            throw new \InvalidArgumentException('ID must be non-empty string or positive integer.');
        }

        $this->clientId = (string)$clientId;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid recipient email.');
        }
        foreach ($variables as $key => $value) {
            if (!is_string($key) || (!is_scalar($value) && $value !== null)) {
                throw new \InvalidArgumentException('Variables must have string keys and scalar or null values.');
            }
        }
    }

    public static function fromArray(array $data): self
    {
        $gender = $data['gender'] ?? null;

        if (isset($data['variables']) && !is_array($data['variables'])) {
            throw new \InvalidArgumentException('Variables must be object.');
        }

        return new self(
            $data['client_id'] ?? null,
            $data['email'] ?? null,
            $data['full_name'] ?? null,
            $gender === null ? null : Gender::from($gender),
            $data['variables'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->clientId,
            'email' => $this->email,
            'full_name' => $this->fullName,
            'gender' => $this->gender?->value,
            'variables' => $this->variables,
        ];
    }
}
