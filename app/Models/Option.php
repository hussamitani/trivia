<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $question_id
 * @property string $text
 * @property bool $is_correct
 * @property int $sort_order
 * @property int $points
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Question $question
 *
 * @method static \Database\Factories\OptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Option extends Model
{
    /** @use HasFactory<\Database\Factories\OptionFactory> */
    use HasFactory;

    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
        'sort_order',
        'points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected $hidden = [
        // 'is_correct',
        // 'points'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
