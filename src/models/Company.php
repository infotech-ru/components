<?php

namespace infotech\components\models;

class Company
{
    public const FORM_OOO = 'ООО';
    public const FORM_AO = 'АО';
    public const FORM_OAO = 'ОАО';
    public const FORM_TOO = 'ТОО';
    public const FORM_IB = 'ИП';
    public const FORM_ZAO = 'ЗАО';
    public const FORM_COOO = 'СООО';
    public const FORM_ODO = 'ОДО';
    public const FORM_CHUP = 'ЧУП';
    public const FORM_CHTUP = 'ЧТУП';
    public const FORM_CHPTUP = 'ЧПТУП';
    public const FORM_FH = 'ФХ';
    public const FORM_PAO = 'ПАО';
    public const FORM_GBY = 'ГБУ';
    public const FORM_CPOK = 'СПОК';
    public const FORM_MOY = 'МОУ';
    public const FORM_FKP = 'ФКП';
    public const FORM_MYYP = 'МУУП';
    public const FORM_DYP = 'ДУП';
    public const FORM_DP = 'ДП';
    public const FORM_PK = 'ПК';
    public const FORM_ART = 'Арт';
    public const FORM_CXK = 'СХК';
    public const FORM_PT = 'ПТ';
    public const FORM_TV = 'ТВ';
    public const FORM_FL = 'ФЛ';
    public const FORM_PRED = 'ПРЕД';
    public const FORM_OO = 'OO'; //https://zakonbase.ru/content/part/291477?print=1
    public const FORM_RO = 'РО';
    public const FORM_F = 'Ф';
    public const FORM_KFX = 'КФХ';
    public const FORM_FGUP = 'ФГУП';
    public const FORM_CHPK = 'СХПК';
    public const FORM_KH = 'KX';
    public const FORM_GKFX = 'ГКФХ';
    public const FORM_FCVNG_RF = 'ФСВНГ РФ';
    public const FORM_FKU = 'ФКУ';
    public const FORM_FKGU = 'ФКГУ';
    public const FORM_SPSSPK = 'СПССПК';
    public const FORM_UFSIN = 'УФСИН';
    public const FORM_NAO = 'НАО';
    public const FORM_ANO = 'АНО';
    public const FORM_SPAO = 'СПАО';

    public static function getLegalFormList(): array
    {
        return [
            self::FORM_OOO => self::FORM_OOO,
            self::FORM_AO => self::FORM_AO,
            self::FORM_OAO => self::FORM_OAO,
            self::FORM_TOO => self::FORM_TOO,
            self::FORM_IB => self::FORM_IB,
            self::FORM_ZAO => self::FORM_ZAO,
            self::FORM_COOO => self::FORM_COOO,
            self::FORM_ODO => self::FORM_ODO,
            self::FORM_CHUP => self::FORM_CHUP,
            self::FORM_CHTUP => self::FORM_CHTUP,
            self::FORM_CHPTUP => self::FORM_CHPTUP,
            self::FORM_FH => self::FORM_FH,
            self::FORM_PAO => self::FORM_PAO,
            self::FORM_GBY => self::FORM_GBY,
            self::FORM_CPOK => self::FORM_CPOK,
            self::FORM_MOY => self::FORM_MOY,
            self::FORM_FKP => self::FORM_FKP,
            self::FORM_MYYP => self::FORM_MYYP,
            self::FORM_DYP => self::FORM_DYP,
            self::FORM_DP => self::FORM_DP,
            self::FORM_PK => self::FORM_PK,
            self::FORM_ART => self::FORM_ART,
            self::FORM_CXK => self::FORM_CXK,
            self::FORM_PT => self::FORM_PT,
            self::FORM_TV => self::FORM_TV,
            self::FORM_FL => self::FORM_FL,
            self::FORM_PRED => self::FORM_PRED,
            self::FORM_OO => self::FORM_OO, // https://zakonbase.ru/content/part/291477?print=1
            self::FORM_RO => self::FORM_RO,
            self::FORM_F => self::FORM_F,
            self::FORM_KFX => self::FORM_KFX,
            self::FORM_FGUP => self::FORM_FGUP,
            self::FORM_CHPK => self::FORM_CHPK,
            self::FORM_KH => self::FORM_KH,
            self::FORM_GKFX => self::FORM_GKFX,
            self::FORM_FCVNG_RF => self::FORM_FCVNG_RF,
            self::FORM_FKU => self::FORM_FKU,
            self::FORM_FKGU => self::FORM_FKGU,
            self::FORM_SPSSPK => self::FORM_SPSSPK,
            self::FORM_UFSIN => self::FORM_UFSIN,
            self::FORM_NAO => self::FORM_NAO,
            self::FORM_ANO => self::FORM_ANO,
            self::FORM_SPAO => self::FORM_SPAO,
        ];
    }
}