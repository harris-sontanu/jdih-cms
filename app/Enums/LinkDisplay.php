<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LinkDisplay: string
{
    use Values;

    case MAIN = 'main';
    case ASIDE = 'aside';
    case POPUP = 'popup';

    public function displayBadge()
    {
        return match ($this) {
            self::MAIN  => '<span class="badge bg-primary bg-opacity-20 text-primary">Utama</span>',
            self::ASIDE => '<span class="badge bg-success bg-opacity-20 text-success">Samping</span>',
            self::POPUP => '<span class="badge bg-pink bg-opacity-20 text-pink">Popup</span>',
        };
    }

    public function label()
    {
        return match ($this) {
            self::MAIN  => 'Utama',
            self::ASIDE => 'Samping',
            self::POPUP => 'Popup',
        };
    }
}