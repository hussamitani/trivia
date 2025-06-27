<?php

namespace App\Filament\Resources\QuestionResource\RelationManagers;

use App\Events\QuizAttemptSubmitted;
use App\Models\Attempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'attempts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('started_at')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('user.name'),
            TextEntry::make('started_at')
                ->date('d.m.Y H:i'),
            RepeatableEntry::make('choices')
                ->schema([
                    TextEntry::make('question.text'),
                    TextEntry::make('selected_options'),
                ])
                ->columns(2)
                ->columnSpan(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('started_at')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('started_at'),
                Tables\Columns\TextColumn::make('final_score'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\Action::make('calculate')
                    ->action(fn (Attempt $record) => event(new QuizAttemptSubmitted($record))),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
