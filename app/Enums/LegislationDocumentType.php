<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LegislationDocumentType: string
{
    use Values;

    case MASTER = 'master';
    case ABSTRACT = 'abstract';
    case ATTACHMENT = 'attachment';
    case COVER = 'cover';

    public function label()
    {
        return match ($this) {
            self::MASTER  => 'Batang Tubuh',
            self::ABSTRACT => 'Abstrak',
            self::ATTACHMENT => 'Lampiran',
            self::COVER => 'Sampul',
        };
    }
}