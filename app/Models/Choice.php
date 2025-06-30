<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $question_id
 * @property int $attempt_id
 * @property array<array-key, mixed> $selected_options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attempt $attempt
 * @property-read \App\Models\Question $question
 *
 * @method static \Database\Factories\ChoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereAttemptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereSelectedOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Choice whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Choice extends Model
{
    /** @use HasFactory<\Database\Factories\ChoiceFactory> */
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'selected_options',
    ];

    protected $casts = [
        'selected_options' => 'array',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }
}
