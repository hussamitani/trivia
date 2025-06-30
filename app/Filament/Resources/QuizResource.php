<?php

namespace App\Filament\Resources;

use App\Enums\QuestionType;
use App\Filament\Resources\QuestionResource\RelationManagers\AttemptsRelationManager;
use App\Filament\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-s-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('questions')
                    ->relationship('questions')
                    ->orderColumn('sort_order')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options(fn () => QuestionType::labels()),
                        Forms\Components\TextInput::make('text')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('options')
                            ->columns(2)
                            ->relationship('options')
                            ->orderColumn('sort_order')
                            ->schema([
                                Forms\Components\TextInput::make('text')
                                    ->required()
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_correct')
                                    ->inline(false)
                                    ->required(),
                                Forms\Components\TextInput::make('points')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                            ]),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('questions_count'),
                Tables\Columns\TextColumn::make('attempts_count'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttemptsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('questions')
            ->withCount('attempts');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'view' => Pages\ViewQuiz::route('/{record}'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
