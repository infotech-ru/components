<?php

namespace infotech\components\models;

enum SttProvider: string
{
    case YANDEX_SPEECH_KIT = 'yandex-speechkit';
    case SPS = 'sps';
    case S2T = 'speech2text';

    public static function getList(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}