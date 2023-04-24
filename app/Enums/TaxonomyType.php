<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum TaxonomyType: string
{
    use Values;

    case NEWS = 'news';
    case PAGE = 'page';
    case EMPLOYEE = 'employee';
    case FORUM = 'forum';
}