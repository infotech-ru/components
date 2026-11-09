<?php

declare(strict_types=1);

namespace infotech\components\mailing\contracts;

use infotech\components\mailing\dto\MailingLimitsDto;
use infotech\components\mailing\dto\RecipientsPageDto;
use infotech\components\mailing\enums\ListType;
use infotech\components\mailing\value\ListReference;
use infotech\components\mailing\value\PageRequest;

interface ApiInterface
{
    public const string KEY_HEADER = 'X-Instance-Key';
    public const string URL_HEADER = 'X-Instance-Url';

    public function limits(string $vendorId): MailingLimitsDto;

    public function lists(string $vendorId, ?ListType $type = null): array;

    public function recipients(
        string $vendorId,
        ListReference $list,
        string $context,
        PageRequest $page = new PageRequest(),
    ): RecipientsPageDto;

    public function variables(string $vendorId, string $context): array;

    public function mailboxes(string $vendorId): array;
}
