<?php

declare(strict_types=1);

namespace infotech\components\mailing\dto;

use infotech\components\mailing\contracts\Arrayable;

final readonly class TemplateVariableDto implements Arrayable
{
    use SerializesToArray;

    public function __construct(public string $name, public string $placeholder, public string $title)
    {
        if ($name === '' || $placeholder === '') {
            throw new \InvalidArgumentException('Variable name and placeholder must not be empty.');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['placeholder'] ?? null,
            $data['title'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'placeholder' => $this->placeholder,
            'title' => $this->title,
        ];
    }
}
