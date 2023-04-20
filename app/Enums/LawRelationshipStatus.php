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
}