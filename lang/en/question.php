<?php

return [
    'type' => [
        \App\Enums\QuestionType::BOOLEAN->value => 'True or False',
        \App\Enums\QuestionType::SINGLE_CHOICE->value => 'Single correct answer',
        \App\Enums\QuestionType::MULTIPLE_CHOICE->value => 'Multiple correct answers',

    ],
];
