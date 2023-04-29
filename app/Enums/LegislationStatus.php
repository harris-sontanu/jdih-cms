<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LegislationStatus: string
{
    use Values;

    case BERLAKU = 'berlaku';
    case TIDAKBERLAKU = 'tidak berlaku';
    case TETAP = 'tetap';
 
    public function label()
    {
        return match ($this) {
            self::BERLAKU  => 'Berlaku',
            self::TIDAKBERLAKU  => 'Tidak Berlaku',
            self::TETAP    => 'Hukum Tetap',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::BERLAKU  => '<span class="badge bg-success bg-opacity-20 text-success">'.$this->label().'</span>',
            self::TIDAKBERLAKU  => '<span class="badge bg-danger bg-opacity-20 text-danger">'.$this->label().'</span>',
            self::TETAP    => '<span class="badge bg-info bg-opacity-20 text-info">'.$this->label().'</span>',
        };
    }
}
