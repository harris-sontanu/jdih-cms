<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LegislationDocumentType
{
    use Values;

    case MASTER ;
    case ABSTRACT;
    case ATTACHMENT;
    case COVER;
}