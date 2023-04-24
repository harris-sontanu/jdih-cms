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
}