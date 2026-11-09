<?php

declare(strict_types=1);

namespace infotech\components\mailing\value;

final readonly class PageRequest
{
    public function __construct(public int $limit = 200, public ?string $afterId = null)
    {
        if ($limit < 1 || ($afterId !== null && trim($afterId) === '')) {
            throw new \InvalidArgumentException();
        }
    }
}
