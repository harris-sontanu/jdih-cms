<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LawRelationshipStatus: string
{
    use Values;

    case MENCABUT = 'mencabut';
    case MENGUBAH = 'mengubah';
    case DICABUT = 'dicabut';
    case DIUBAH = 'diubah';
    case MELAKSANAKAN = 'melaksanakan';
    case DILAKSANAKAN = 'dilaksanakan';
 
    public function label()
    {
        return match ($this) {
            self::MENCABUT  => 'Mencabut',
            self::MENGUBAH  => 'Mengubah',
            self::DICABUT   => 'Dicabut dengan',
            self::DIUBAH    => 'Diubah dengan',
            self::MELAKSANAKAN => 'Melaksanakan',
            self::DILAKSANAKAN => 'Dilaksanakan dengan',
        };
    }

    public function antonym()
    {
        return match ($this) {
            self::MENCABUT  => 'dicabut',
            self::MENGUBAH  => 'diubah',
            self::DICABUT   => 'mencabut',
            self::DIUBAH    => 'mengubah',
            self::MELAKSANAKAN => 'dilaksanakan',
            self::DILAKSANAKAN => 'melaksanakan',
        };
    }

    public function antonymLabel()
    {
        return match ($this) {
            self::MENCABUT  => 'Dicabut dengan',
            self::MENGUBAH  => 'Diubah dengan',
            self::DICABUT   => 'Mencabut',
            self::DIUBAH    => 'Mengubah',
            self::MELAKSANAKAN => 'Dilaksanakan dengan',
            self::DILAKSANAKAN => 'Melaksanakan',
        };
    }
}
