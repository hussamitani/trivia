<?php

namespace App\Models;

use Database\Factories\AttemptFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $quiz_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property int|null $final_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Choice> $choices
 * @property-read int|null $choices_count
 * @property-read \App\Models\Quiz $quiz
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\AttemptFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereFinalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attempt whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Attempt extends Model
{
    /** @use HasFactory<AttemptFactory> */
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}
