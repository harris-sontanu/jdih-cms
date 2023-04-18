<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum QuestionType
{
    use Values;

    case IDENTITY;
    case QUESTION;
}