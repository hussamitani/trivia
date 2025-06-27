<?php

namespace Tests\Feature;

use App\Enums\QuestionType;
use App\Events\QuizAttemptSubmitted;
use App\Models\Attempt;
use App\Models\Choice;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttemptCalculatePointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_setup_quiz()
    {
        self::assertEquals(0, Quiz::query()->count());
        self::assertEquals(4, 2 + 2);

        $quiz = $this->setupQuiz();

        self::assertEquals(1, Quiz::query()->count());
        self::assertEquals(1, Question::query()->count());
        self::assertEquals(2, Option::query()->count());
    }

    public function test_attempt_quiz()
    {
        $quiz = $this->setupQuiz();

        $attempt = Attempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => User::factory()->create()->id,
            'started_at' => now()->subMinutes(5),
            'ended_at' => now(),
        ]);

        $attempt->choices()->create([
            'question_id' => $quiz->questions->first()->id,
            'selected_options' => [$quiz->questions->first()->options->first()->id],
        ]);

        self::assertEquals(1, Attempt::query()->count());
        self::assertEquals(1, Choice::query()->count());

        self::assertEquals(0, $attempt->final_score);
        event(new QuizAttemptSubmitted($attempt));
        self::assertEquals(2, $attempt->final_score);
    }

    public function setupQuiz(): Quiz
    {
        $quiz = Quiz::factory()->create();

        /** @var Question $question */
        $question = $quiz->questions()->create([
            'text' => 'What is 2+2',
            'type' => QuestionType::SINGLE_CHOICE,
        ]);

        $question->options()->create([
            'text' => '4',
            'points' => '2',
        ]);

        $question->options()->create([
            'text' => '5',
            'points' => '0',
        ]);

        return $quiz;
    }
}
