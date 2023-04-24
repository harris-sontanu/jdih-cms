<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LinkDisplay: string
{
    use Values;

    case MAIN = 'main';
    case ASIDE = 'aside';
    case POPUP = 'popup';
}