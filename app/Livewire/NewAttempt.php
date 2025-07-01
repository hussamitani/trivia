<?php

namespace App\Livewire;

use App\Events\QuizAttemptSubmitted;
use App\Models\Attempt;
use App\Models\Quiz;
use Illuminate\Support\Carbon;
use Livewire\Component;

class NewAttempt extends Component
{
    public int $quiz_id;

    public Quiz $quiz;

    public Carbon $started_at;

    public string $time = '00:00:00';

    public function updateElapsed(): void
    {
        $this->time = now()->diff($this->started_at)->format('%H:%I:%S');
    }

    public function mount()
    {
        $this->started_at = Carbon::now();
        $this->time = now()->diff($this->started_at)->format('%H:%I:%S');
        $this->quiz = Quiz::query()->find($this->quiz_id)
            ->load('questions.options')
            ->load(['attempts' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }]);
    }

    public function render()
    {
        return view('livewire.new-attempt');
    }

    public int $currentQuestion = 0;

    public array $answers = [];

    public function nextQuestion()
    {
        if ($this->currentQuestion < $this->quiz->questions->count() - 1) {
            $this->currentQuestion++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestion > 0) {
            $this->currentQuestion--;
        }
    }

    public function toggleOption($questionId, $optionId)
    {
        $question = $this->quiz->questions->firstWhere('id', $questionId);
        $isMultiple = $question->type->value === 'multiple';

        if ($isMultiple) {
            $selected = $this->answers[$questionId] ?? [];
            if (in_array($optionId, $selected)) {
                $this->answers[$questionId] = array_diff($selected, [$optionId]);
            } else {
                $this->answers[$questionId] = array_merge($selected, [$optionId]);
            }
        } else {
            $this->answers[$questionId] = $optionId;
        }
    }

    public function submit()
    {
        $attempt = Attempt::create([
            'quiz_id' => $this->quiz->id,
            'user_id' => auth()->user()->id,
            'started_at' => $this->started_at,
            'ended_at' => now(),
        ]);

        foreach ($this->answers as $questionId => $selected) {
            // $selected is either an int (single) or array (multiple)
            // Example: save to DB, validate, etc.
            // You can check if it's an array:
            if (is_array($selected)) {
                // Multi-select: $selected is an array of option IDs
                $attempt->choices()->create([
                    'question_id' => $questionId,
                    'selected_options' => $selected,
                ]);
            } else {
                // Single-select: $selected is the option ID
                $attempt->choices()->create([
                    'question_id' => $questionId,
                    'selected_options' => [$selected],
                ]);
            }
        }

        event(new QuizAttemptSubmitted($attempt));
        $this->redirect(route('attempt.view', $attempt->id));
    }
}
