<?php

namespace infotech\components\models;

enum GptVendor: string
{
    case OPEN_ROUTER = 'openRouter';
    case YANDEX_AI = 'yandexAi';
    case YANDEX_AI_PERSONAL = 'yandexAiP';

    public static function getList(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}