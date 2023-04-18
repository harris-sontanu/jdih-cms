<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LinkType
{
    use Values;

    case BANNER;
    case JDIH;
    case YOUTUBE;
}