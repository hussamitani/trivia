<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $quiz_id
 * @property string $text
 * @property QuestionType $type
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Choice> $choices
 * @property-read int|null $choices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Option> $options
 * @property-read int|null $options_count
 * @property-read \App\Models\Quiz $quiz
 * @property-read mixed $total_points
 *
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $appends = ['total_points'];

    protected $fillable = [
        'quiz_id',
        'text',
        'type',
        'sort_order',
    ];

    protected $casts = [
        'type' => QuestionType::class,
        'sort_order' => 'int',
    ];

    public function totalPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->options()->sum('points')
        );
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('sort_order', 'asc');
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}
