<?php

namespace infotech\components\models;

use ReflectionClass;

/**
 * @see https://zakonbase.ru/content/part/291477?print=1
 * @see https://rosstat.gov.ru/opendata/7708234640-okopf
 */
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
    public const FORM_OO = 'OO';
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
    public const FORM_ASSOC = 'Ассоциация';
    public const FORM_CHU = 'ЧУ'; // Код ОКОПФ: 75500.
    public const FORM_NOCHU = 'НОЧУ';
    public const FORM_GUP = 'ГУП';
    public const FORM_OOB = 'ООБ';
    public const FORM_ROB = 'РОБ';
    public const FORM_CHURCH = 'Церковь';
    public const FORM_COMING = 'Приход';
    public const FORM_COMMUNITY = 'Община';
    public const FORM_MONASTERY = 'Монастырь';
    public const FORM_MISSION = 'Миссия';
    public const FORM_FOND = 'Фонд';
    public const FORM_NP = 'НП';
    public const FORM_UCH = 'Уч';
    public const FORM_GUCH = 'ГУЧ';
    public const FORM_MUCH = 'МУЧ';
    public const FORM_OUCH = 'ОУЧ';
    public const FORM_UNION = 'Союз';
    public const FORM_TSZH = 'ТСЖ';
    public const FORM_CNDMNM = 'Кондоминиум';
    public const FORM_PTK = 'ПТК';
    public const FORM_OD = 'ОД';
    public const FORM_OF = 'ОФ';
    public const FORM_OOS = 'ООС';
    public const FORM_DOUC = 'ДОУч';
    public const FORM_OPROF = 'Опроф';
    public const FORM_TOPROF = 'ТОПроф';
    public const FORM_PPO = 'ППО';
    public const FORM_PARTY = 'Партия';
    public const FORM_AOZT = 'АОЗТ';
    public const FORM_AOOT = 'АООТ';
    public const FORM_MP = 'МП';
    public const FORM_ICHP = 'ИЧП';
    public const FORM_SEM = 'СЕМ';
    public const FORM_SP = 'СП';
    public const FORM_GP = 'ГП';
    public const FORM_MUP = 'МУП';
    public const FORM_POO = 'ПОО';
    public const FORM_PPKOOP = 'ППКООП';
    public const FORM_UOO = 'УОО';
    public const FORM_UCHPTK = 'УЧПТК';
    public const FORM_KOMBANK = 'Комбанк';
    public const FORM_SMT = 'СМТ';
    public const FORM_ST = 'СТ';
    public const FORM_KLH = 'КЛХ';
    public const FORM_SVH = 'СВХ';
    public const FORM_ZHSK = 'ЖСК';
    public const FORM_GSK = 'ГСК';
    public const FORM_FIRM = 'Фирма';
    public const FORM_NPO = 'НПО';
    public const FORM_PO = 'ПО';
    public const FORM_SKB = 'СКБ';
    public const FORM_KB = 'КБ';
    public const FORM_UPTK = 'УПТК';
    public const FORM_SMU = 'СМУ';
    public const FORM_HOZU = 'ХОЗУ';
    public const FORM_NTC = 'НТЦ';
    public const FORM_FIK = 'ФИК';
    public const FORM_NPP = 'НПП';
    public const FORM_CHIF = 'ЧИФ';
    public const FORM_CHOP = 'ЧОП';
    public const FORM_REU = 'РЭУ';
    public const FORM_PIF = 'ПИФ';
    public const FORM_GKOOP = 'ГКООП';
    public const FORM_POB = 'ПОБ';
    public const FORM_PS = 'ПС';
    public const FORM_KS = 'КС';
    public const FORM_FF = 'ФФ';
    public const FORM_FPG = 'ФПГ';
    public const FORM_MHP = 'МХП';
    public const FORM_LPH = 'ЛПХ';
    public const FORM_AP = 'АП';
    public const FORM_OP = 'ОП';
    public const FORM_NPF = 'НПФ';
    public const FORM_PKF = 'ПКФ';
    public const FORM_PKP = 'ПКП';
    public const FORM_PKK = 'ПКК';
    public const FORM_KF = 'КФ';
    public const FORM_TF = 'ТФ';
    public const FORM_TD = 'ТД';
    public const FORM_DSU = 'Д(С)У';
    public const FORM_TFPG = 'ТФПГ';
    public const FORM_MFPG = 'МФПГ';
    public const FORM_DS = 'Д/С';
    public const FORM_BCA = 'Б-ца';
    public const FORM_PKA = 'П-ка';
    public const FORM_AKA = 'А-ка';
    public const FORM_ZD = 'З-д';
    public const FORM_ADOK = 'АДОК';
    public const FORM_REDSMI = 'РедСМИ';
    public const FORM_PRT = 'ПрТ';
    public const FORM_APAOOT = 'АПАООТ';
    public const FORM_OPAOOT = 'ОПАООТ';
    public const FORM_OPAOZT = 'ОПАОЗТ';
    public const FORM_OPTOO = 'ОПТОО';
    public const FORM_APAOZT = 'АПАОЗТ';
    public const FORM_APTOO = 'АПТОО';
    public const FORM_APST = 'АПСТ';
    public const FORM_APPT = 'АППТ';
    public const FORM_OPST = 'ОПСТ';
    public const FORM_OPPT = 'ОППТ';
    public const FORM_ASKFH = 'АСКФХ';
    public const FORM_SOYUZKFH = 'СОЮЗКФХ';
    public const FORM_SOYUZPOB = 'СОЮЗПОБ';
    public const FORM_SCHOOL = 'Школа';
    public const FORM_INT = 'Ин-т';
    public const FORM_RSU = 'РСУ';
    public const FORM_CORP = 'Корп';
    public const FORM_COMP = 'Комп';
    public const FORM_BKA = 'Б-ка';
    public const FORM_BSP = 'БСП';
    public const FORM_CRB = 'ЦРБ';
    public const FORM_MUUCH = 'МУУЧ';
    public const FORM_MSCH = 'МСЧ';
    public const FORM_CRBUH = 'ЦРБУХ';
    public const FORM_CBUH = 'ЦБУХ';
    public const FORM_FNDL = 'ФИНОТДЕЛ';
    public const FORM_KC = 'КЦ';
    public const FORM_PROFKOM = 'ПРОФКОМ';
    public const FORM_ATP = 'АТП';
    public const FORM_PATP = 'ПАТП';
    public const FORM_CDN = 'ЦДН';
    public const FORM_NOTP = 'НОТП';
    public const FORM_NOTK = 'НОТК';
    public const FORM_YAS = 'Я/С';
    public const FORM_OTD = 'ОТД';
    public const FORM_ZHD = 'ЖД';
    public const FORM_KOOP = 'КООП';
    public const FORM_BU = 'БУ';
    public const FORM_SAU = 'САУ';
    public const FORM_KU = 'КУ';
    public const FORM_AOOO = 'ПРЕДСТАВИТЕЛЬСТВО АООО';
    public const FORM_FGAU = 'ФГАУ'; // Код ОКОПФ: 75101.
    public const FORM_FGBU = 'ФГБУ'; // Код ОКОПФ: 75103.
    public const FORM_FGKU = 'ФГКУ'; // Код ОКОПФ: 75104.
    public const FORM_FBUZ = 'ФБУЗ';
    public const FORM_SPK = 'СПК';
    public const FORM_SPO = 'СПО'; // Код ОКОПФ: 20608.
    public const FORM_GAU = 'ГАУ';
    public const FORM_MKU = 'МКУ';
    public const FORM_BF = 'БФ'; // Код ОКОПФ: 70401.
    public const FORM_NKO = 'НКО'; // НКО Некоммерческая организация ОКОПФ: 71400
    public const FORM_GKU = 'ГКУ'; // ГКУ Государственное казённое учреждение ОКОПФ: 75204
    public const FORM_KPK = 'КПК'; // КПК Кредитный потребительский кооператив ОКОПФ: 20104
    public const FORM_FBUN = 'ФБУН'; // ФБУН Федеральное бюджетное учреждение науки ОКОПФ: 75103
    public const FORM_EMBASSY = 'Посольство'; // Посольство ОКОПФ: 40000
    public const FORM_MAU = 'МАУ'; // Муниципальное автономное учреждение ОКОПФ: 75401
    public const FORM_KGKU = 'КГКУ'; //КРАЕВОЕ ГОСУДАРСТВЕННОЕ КАЗЕННОЕ УЧРЕЖДЕНИЕ
    public const FORM_MOO = 'МОО'; //Межрегиональная общественная организация
    public const FORM_OcOO = 'ОсОО'; //Кыргызский вариант Общества с ограниченной ответственностью

    public static function getLegalFormList(): array
    {
        $reflection = new ReflectionClass(self::class);
        $forms = array_values($reflection->getConstants());

        return array_combine($forms, $forms);
    }

    public static function getLegalFormListWithFullName(): array
    {
        return [
            self::FORM_OOO => 'Общество с ограниченной ответственностью',
            self::FORM_AO => 'Акционерное общество',
            self::FORM_OAO => 'Открытое акционерное общество',
            self::FORM_TOO => 'Товарищество с ограниченной ответственностью',
            self::FORM_IB => 'Индивидуальный предприниматель',
            self::FORM_ZAO => 'Закрытое акционерное общество',
            self::FORM_COOO => 'Совместное общество с ограниченной ответственностью',
            self::FORM_ODO => 'Общество с дополнительной ответственностью',
            self::FORM_CHUP => 'Частное унитарное предприятие',
            self::FORM_CHTUP => 'Частное торговое унитарное предприятие',
            self::FORM_CHPTUP => 'Частное производственно-торговое унитарное предприятие',
            self::FORM_FH => 'Фермерское хозяйство',
            self::FORM_PAO => 'Публичное акционерное общество',
            self::FORM_GBY => 'Государственное бюджетное учреждение',
            self::FORM_CPOK => 'Сельский потребительский кооператив',
            self::FORM_MOY => 'Муниципальное образовательное учреждение',
            self::FORM_FKP => 'Федеральное казенное предприятие',
            self::FORM_MYYP => 'Муниципальное унитарное предприятие',
            self::FORM_DYP => 'Дочернее унитарное предприятие',
            self::FORM_DP => 'Дочернее предприятие',
            self::FORM_PK => 'Производственный кооператив',
            self::FORM_ART => 'Артель',
            self::FORM_CXK => 'Сельскохозяйственный кооператив',
            self::FORM_PT => 'Полное товарищество',
            self::FORM_TV => 'Товарищество на вере',
            self::FORM_FL => 'Филиал',
            self::FORM_PRED => 'Представительство',
            self::FORM_OO => 'Общественная организация',
            self::FORM_RO => 'Религиозная организация',
            self::FORM_F => 'Фонд',
            self::FORM_KFX => 'Крестьянское (фермерское) хозяйство',
            self::FORM_FGUP => 'Федеральное государственное унитарное предприятие',
            self::FORM_CHPK => 'Сельскохозяйственный производственный кооператив',
            self::FORM_KH => 'Крестьянское хозяйство',
            self::FORM_GKFX => 'Глава крестьянского (фермерского) хозяйства',
            self::FORM_FCVNG_RF => 'ФСВНГ РФ',
            self::FORM_FKU => 'Федеральное казенное учреждение',
            self::FORM_FKGU => 'Федеральное казенное государственное учреждение',
            self::FORM_SPSSPK => 'Сельскохозяйственный перерабатывающий снабженческо-сбытовой потребительский кооператив',
            self::FORM_UFSIN => 'УФСИН',
            self::FORM_NAO => 'Непубличное акционерное общество',
            self::FORM_ANO => 'Автономная некоммерческая организация',
            self::FORM_SPAO => 'Страховое публичное акционерное общество',
            self::FORM_ASSOC => 'Ассоциация',
            self::FORM_CHU => 'Частное учреждение',
            self::FORM_NOCHU => 'Негосударственное образовательное частное учреждение',
            self::FORM_GUP => 'Государственное унитарное предприятие',
            self::FORM_OOB => 'Общественное объединение',
            self::FORM_ROB => 'Религиозное общество',
            self::FORM_CHURCH => 'Церковь',
            self::FORM_COMING => 'Приход',
            self::FORM_COMMUNITY => 'Община',
            self::FORM_MONASTERY => 'Монастырь',
            self::FORM_MISSION => 'Миссия',
            self::FORM_FOND => 'Фонд',
            self::FORM_NP => 'Некоммерческое партнерство',
            self::FORM_UCH => 'Учреждение',
            self::FORM_GUCH => 'Государственное учреждение',
            self::FORM_MUCH => 'Муниципальное учреждение',
            self::FORM_OUCH => 'Общественное учреждение',
            self::FORM_UNION => 'Союз',
            self::FORM_TSZH => 'Товарищество собственников жилья',
            self::FORM_CNDMNM => 'Кондоминиум',
            self::FORM_PTK => 'Потребительский кооператив',
            self::FORM_OD => 'Общественное движение',
            self::FORM_OF => 'Общественный фонд',
            self::FORM_OOS => 'Орган общественной самодеятельности',
            self::FORM_DOUC => 'Духовное образовательное учреждение',
            self::FORM_OPROF => 'Общероссийский профсоюз',
            self::FORM_TOPROF => 'Территориальная организация профсоюза',
            self::FORM_PPO => 'Первичная профсоюзная организация',
            self::FORM_PARTY => 'Партия',
            self::FORM_AOZT => 'Акционерное общество закрытого типа',
            self::FORM_AOOT => 'Акционерное общество открытого типа',
            self::FORM_MP => 'Малое предприятие',
            self::FORM_ICHP => 'Индивидуальное частное предприятие',
            self::FORM_SEM => 'Семейное предприятие',
            self::FORM_SP => 'Совместное предприятие',
            self::FORM_GP => 'Государственное предприятие',
            self::FORM_MUP => 'Муниципальное предприятие',
            self::FORM_POO => 'Предприятие общественной организации',
            self::FORM_PPKOOP => 'Предприятие потребительской кооперации',
            self::FORM_UOO => 'Учреждение общественной организации',
            self::FORM_UCHPTK => 'Учреждение потребительской кооперации',
            self::FORM_KOMBANK => 'Коммерческий банк',
            self::FORM_SMT => 'Смешанное товарищество',
            self::FORM_ST => 'Садоводческое товарищество',
            self::FORM_KLH => 'Колхоз',
            self::FORM_SVH => 'Совхоз',
            self::FORM_ZHSK => 'Жилищно-строительный кооператив',
            self::FORM_GSK => 'Гаражно-строительный кооператив',
            self::FORM_FIRM => 'Фирма',
            self::FORM_NPO => 'Научно-производственное объединение',
            self::FORM_PO => 'Производственное объединение',
            self::FORM_SKB => 'Специализированное конструкторское бюро',
            self::FORM_KB => 'Конструкторское бюро',
            self::FORM_UPTK => 'Управление производственно-технической комплектации',
            self::FORM_SMU => 'Строительно-монтажное управление',
            self::FORM_HOZU => 'Хозяйственное управление',
            self::FORM_NTC => 'Научно-технический центр',
            self::FORM_FIK => 'Финансово-инвестиционная компания',
            self::FORM_NPP => 'Научно-производственное предприятие',
            self::FORM_CHIF => 'Чековый инвестиционный фонд',
            self::FORM_CHOP => 'Частное охранное предприятие',
            self::FORM_REU => 'Ремонтно-эксплуатационное управление',
            self::FORM_PIF => 'Паевой инвестиционный фонд',
            self::FORM_GKOOP => 'Гаражный кооператив',
            self::FORM_POB => 'Потребительское общество',
            self::FORM_PS => 'Потребительский союз',
            self::FORM_KS => 'Кредитный союз',
            self::FORM_FF => 'Филиал фонда',
            self::FORM_FPG => 'Финансово-промышленная группа',
            self::FORM_MHP => 'Межхозяйственное предприятие',
            self::FORM_LPH => 'Личное подсобное хозяйство',
            self::FORM_AP => 'Арендное предприятие',
            self::FORM_OP => 'Объединение предприятий',
            self::FORM_NPF => 'Научно-производственная фирма',
            self::FORM_PKF => 'Производственно-коммерческая фирма',
            self::FORM_PKP => 'Производственно-коммерческое предприятие',
            self::FORM_PKK => 'Производственно-коммерческая компания',
            self::FORM_KF => 'Коммерческая фирма',
            self::FORM_TF => 'Торговая фирма',
            self::FORM_TD => 'Торговый дом',
            self::FORM_DSU => 'Дорожное (строительное) управление',
            self::FORM_TFPG => 'Транснациональная финансово-промышленная группа',
            self::FORM_MFPG => 'Межгосударственная финансово-промышленная группа',
            self::FORM_DS => 'Детский сад',
            self::FORM_BCA => 'Больница',
            self::FORM_PKA => 'Поликлиника',
            self::FORM_AKA => 'Аптека',
            self::FORM_ZD => 'Завод',
            self::FORM_ADOK => 'Административный округ',
            self::FORM_REDSMI => 'Редакция средства массовой информации',
            self::FORM_PRT => 'Простое товарищество',
            self::FORM_APAOOT => 'Арендное предприятие в форме акционерного общества открытого типа',
            self::FORM_OPAOOT => 'Объединение предприятий в форме акционерного общества открытого типа',
            self::FORM_OPAOZT => 'Объединение предприятий в форме акционерного общества закрытого типа',
            self::FORM_OPTOO => 'Объединение предприятий в форме товарищества с ограниченной ответственностью',
            self::FORM_APAOZT => 'Арендное предприятие в форме акционерного общества закрытого типа',
            self::FORM_APTOO => 'Арендное предприятие в форме товарищества с ограниченной ответственностью',
            self::FORM_APST => 'Арендное предприятие в форме смешанного товарищества',
            self::FORM_APPT => 'Арендное предприятие в форме полного товарищества',
            self::FORM_OPST => 'Объединение предприятий в форме смешанного товарищества',
            self::FORM_OPPT => 'Объединение предприятий в форме полного товарищества',
            self::FORM_ASKFH => 'Ассоциация крестьянских (фермерских) хозяйств',
            self::FORM_SOYUZKFH => 'Союз крестьянских (фермерских) хозяйств',
            self::FORM_SOYUZPOB => 'Союз потребительских обществ',
            self::FORM_SCHOOL => 'Школа',
            self::FORM_INT => 'Институт',
            self::FORM_RSU => 'Ремонтно-строительное управление',
            self::FORM_CORP => 'Корпорация',
            self::FORM_COMP => 'Компания',
            self::FORM_BKA => 'Библиотека',
            self::FORM_BSP => 'Больница скорой помощи',
            self::FORM_CRB => 'Центральная районная больница',
            self::FORM_MUUCH => 'Муниципальное унитарное учреждение',
            self::FORM_MSCH => 'Медсанчасть',
            self::FORM_CRBUH => 'Централизованная районная бухгалтерия',
            self::FORM_CBUH => 'Централизованная бухгалтерия',
            self::FORM_FNDL => 'Финансовый отдел',
            self::FORM_KC => 'Коммерческий центр',
            self::FORM_PROFKOM => 'Профсоюзный комитет',
            self::FORM_ATP => 'Автотранспортное предприятие',
            self::FORM_PATP => 'Пассажирское автотранспортное предприятие',
            self::FORM_CDN => 'Центр досуга населения',
            self::FORM_NOTP => 'Нотариальная палата',
            self::FORM_NOTK => 'Нотариальная контора',
            self::FORM_YAS => 'Ясли-сад',
            self::FORM_OTD => 'Отделение',
            self::FORM_ZHD => 'Железная дорога',
            self::FORM_KOOP => 'Кооператив',
            self::FORM_BU => 'Бюджетное учреждение',
            self::FORM_SAU => 'САУ',
            self::FORM_KU => 'Казенное учреждение',
            self::FORM_AOOO => 'Представительство акционерного общества с ограниченной ответственностью',
            self::FORM_FGAU => 'Федеральное государственное автономное учреждение',
            self::FORM_FGBU => 'Федеральное государственное бюджетное учреждение',
            self::FORM_FGKU => 'Федеральное государственное казенное учреждение',
            self::FORM_FBUZ => 'Федеральное бюджетное учреждение здравоохранения',
            self::FORM_SPK => 'Сельскохозяйственный производственный кооператив',
            self::FORM_SPO => 'Союзы потребительских обществ',
            self::FORM_GAU => 'Государственное автономное учреждение',
            self::FORM_MKU => 'Муниципальное казенное учреждение',
            self::FORM_BF => 'Благотворительный фонд',
            self::FORM_NKO => 'Некоммерческая организация',
            self::FORM_GKU => 'Государственное казённое учреждение',
            self::FORM_KPK => 'Кредитный потребительский кооператив',
            self::FORM_FBUN => 'Федеральное бюджетное учреждение науки',
            self::FORM_EMBASSY => 'Посольство',
            self::FORM_MAU => 'Муниципальное автономное учреждение',
            self::FORM_KGKU => 'Краевое государственное казенное учреждение',
            self::FORM_MOO => 'Межрегиональная общественная организация',
            self::FORM_OcOO => 'Кыргызский вариант Общества с ограниченной ответственностью',
        ];
    }
}
