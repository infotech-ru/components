<?php

namespace infotech\components\models;

enum CrmSalonOptionCode: string
{
    case SERVICE = 'service';
    case BODY = 'body';
    case LOGIC_STARS = 'logic-stars';
    case MAX_POSTER = 'max-poster';
    case CM_EXPERT = 'cm-expert';
    case WAZZUP = 'wazzup';
    case TRANSCRIPT_BY_VIN = 'transcript-by-vin';
    case API = 'api';
    case CM_EXPERT_WAREHOUSE = 'cm-expert-warehouse';
    case MAX_POSTER_WAREHOUSE = 'max-poster-warehouse';
    case BACHATA = 'bachata';
    case CLASSIFICATION = 'classification';
    case ADD_BRAND = 'add-brand';
    case MODULE_1C = 'module-1c';
    case CALLTOUCH = 'calltouch';
    case IP_TELEPHONY = 'ip-telephony';
    case MOSKVICH = 'moskvich';
    case DNM_DISCOUNT = 'dnm-discount';
    case SHOWCASE = 'showcase';
    case STAT_CALL_TRACKING = 'stat-call-tracking';
    case CONTACT_CENTER = 'contact-center';
    case ELT = 'elt';
    case FAST = 'fast';
    case SPEECH_ANALYTICS = 'speech-analytics';
    case TELEPHONY_ADVANCED_INTEGRATION = 'telephony-advanced-integration';
    case UNLIMITED_FILE_STORAGE = 'unlimited-file-storage';
    case MAX_AND_TG_DISPLAY_EVENTS = 'max-and-tg-display-events';

    public static function getList(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
