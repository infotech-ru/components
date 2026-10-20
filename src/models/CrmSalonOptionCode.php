<?php

namespace infotech\components\models;

enum CrmSalonOptionCode: string
{
    case SERVICE = 'service';
    case BODY = 'body';
    case LOGIC_STARS = 'logic-stars';
    case MAX_POSTER = 'max-poster';
    case CM_EXPERT = 'cm-expert';

    public static function getList(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
