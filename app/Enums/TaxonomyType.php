<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum TaxonomyType
{
    use Values;

    case NEWS;
    case PAGE;
    case EMPLOYEE;
    case FORUM;
}