<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LinkType: string
{
    use Values;

    case BANNER = 'banner';
    case JDIH = 'jdih';
    case YOUTUBE = 'youtube';
}