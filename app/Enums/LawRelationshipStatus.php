<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LawRelationshipStatus: string
{
    use Values;

    case mencabut = 'Mencabut';
    case mengubah = 'Mengubah';
    case dicabut = 'Dicabut dengan';
    case diubah = 'Diubah dengan';
}
