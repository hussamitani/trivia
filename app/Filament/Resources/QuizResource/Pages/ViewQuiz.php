<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use App\Models\Quiz;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;

/**
 * @property-read Quiz $record
 */
class ViewQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make('Play')
                ->label('Let\'s Play')
                ->color(Color::Blue)
                ->icon('heroicon-s-bolt')
                ->url(route('quiz.attempt', $this->record)),
            Actions\EditAction::make(),
        ];
    }
}
