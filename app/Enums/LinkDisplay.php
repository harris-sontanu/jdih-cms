<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LinkDisplay
{
    use Values;

    case MAIN;
    case ASIDE;
    case POPUP;
}