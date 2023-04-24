<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum SlidePosition: string
{
    use Values;

    case TOP = 'top';
    case CENTER = 'center';
    case BOTTOM = 'bottom';

    public function label()
    {
        return match ($this) {
            self::TOP       => 'Atas',
            self::CENTER    => 'Tengah',
            self::BOTTOM    => 'Bawah',
        };
    }
}