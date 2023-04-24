<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LegislationRelationshipType: string
{
    use Values;

    case STATUS = 'status';
    case LEGISLATION = 'legislation';
    case DOCUMENT = 'document';

    public function logMessage ()
    {
        return match ($this) {
            self::STATUS    => 'keterangan status',
            self::LEGISLATION => 'peraturan terkait',
            self::DOCUMENT  => 'dokumen terkait',
        };
    }
}