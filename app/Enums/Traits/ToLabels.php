<?php

namespace App\Enums\Traits;

use App\Enums\QuestionType;

trait ToLabels
{
    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn (QuestionType $type) => [$type->value => $type->label()])->toArray();
    }

    public function label(): string
    {
        return trans(static::label.'.'.$this->value);
    }
}
