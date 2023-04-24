<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum QuestionType: string
{
    use Values;

    case IDENTITY = 'identity';
    case QUESTION = 'question';
}