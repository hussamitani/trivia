<?php

namespace App\Listeners;

use App\Events\QuizAttemptSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalculateAttemptPointsListener // implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(QuizAttemptSubmitted $event): void
    {
        $quiz = $event->attempt->quiz;
        $choices = $event->attempt->choices;

        $points = 0;
        foreach ($quiz->questions as $question) {
            $temp = 0;
            $questionChoice = $choices->where('question_id', $question->id)->first();
            if (!$questionChoice?->selected_options) {
                continue; // Skip if no choice was made for this question
            }
            $selectedOptions = $questionChoice->selected_options;
            $temp += $this->getPointsForCorrectChoices($question, $selectedOptions);
            $temp -= $this->getNegativePointsForWronglySelectedChoices($question, $selectedOptions);
            // $temp -= $this->getMissedPointsForNotSelectedCorrectOptions($question, $selectedOptions);

            $points += max(0, $temp);
        }

        $event->attempt->update([
            'final_score' => max(0, $points),
        ]);
    }

    public function getPointsForCorrectChoices(mixed $question, array $selectedOptions): float|int
    {
        return $question->options
            ->where('is_correct', true)
            ->whereIn('id', $selectedOptions)
            ->pluck('points')
            ->sum();
    }

    public function getMissedPointsForNotSelectedCorrectOptions(mixed $question, array $selectedOptions): float|int
    {
        return $question->options
            ->where('is_correct', true)
            ->whereNotIn('id', $selectedOptions)
            ->pluck('points')
            ->sum();
    }

    private function getNegativePointsForWronglySelectedChoices(mixed $question, array $selectedOptions): float|int
    {
        $averagePoints = $question->options
            ->where('is_correct', false)
            ->pluck('points')
            ->avg();

        return $question->options
            ->where('is_correct', false)
            ->whereIn('id', $selectedOptions)
            ->count() * $averagePoints;
    }
}
