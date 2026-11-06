<?php

namespace infotech\components\mailing\contracts;

/**
 * Нужно для реализации связки мейлера с инстансом
 * $vendorId - id зависимости. На CRM - salonId, на DNM - dealerId
 */
interface ApiInterface
{
    public const string LIST_TYPE_STATIC = 'static';
    public const string LIST_TYPE_DYNAMIC = 'dynamic';
    public const string KEY_HEADER = 'X-Instance-Key';
    public const string URL_HEADER = 'X-Instance-Url';

    /** @return array{max_recipients: int} */
    public function getLimits(int $vendorId): array;

    /** @return list<array{id: string, name: string, type: string}> */
    public function getLists(int $vendorId, ?string $type = null): array;

    /**
     * @return list<array{client_id: string, email: string, full_name: string, gender: ?string, variables: array<string, scalar|null>}>
     */
    public function getListClients(int $vendorId, int $listId, string $type, string $context): array;

    /** @return list<array{name: string, placeholder: string, title: string}> */
    public function getVariables(int $vendorId, string $context): array;
}