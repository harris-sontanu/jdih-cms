<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum SlidePosition: string
{
    use Names;

    case TOP = 'atas';
    case CENTER = 'tengah';
    case BOTTOM = 'bawah';
}