<?php

namespace App\Enums;

use App\Enums\Traits\ToLabels;
use App\Enums\Traits\ToOptions;

enum QuestionType: string
{
    use ToLabels, ToOptions;

    private const label = 'question.type';

    case SINGLE_CHOICE = 'single';
    case MULTIPLE_CHOICE = 'multiple';
    case BOOLEAN = 'boolean';
}
