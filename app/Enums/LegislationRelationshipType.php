<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LegislationRelationshipType
{
    use Values;

    case STATUS;
    case LEGISLATION;
    case DOCUMENT;
}