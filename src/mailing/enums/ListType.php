<?php

declare(strict_types=1);

namespace infotech\components\mailing\enums;

enum ListType: string
{
    case Static = 'static';
    case Dynamic = 'dynamic';
}
