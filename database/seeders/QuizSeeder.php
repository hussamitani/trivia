<?php

namespace Database\Seeders;

use App\Enums\QuestionType;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // load json from database/data
        $this->importQuiz(database_path('data/quiz_1.json'));
        $this->importQuiz(database_path('data/quiz_2.json'));
        $this->importQuiz(database_path('data/quiz_3.json'));
        $this->importQuiz(database_path('data/quiz_4.json'));
        $this->importQuiz(database_path('data/quiz_5.json'));
        $this->importQuiz(database_path('data/quiz_6.json'));
        $this->importQuiz(database_path('data/quiz_7.json'));
        $this->importQuiz(database_path('data/quiz_8.json'));
        $this->importQuiz(database_path('data/quiz_9.json'));
        $this->importQuiz(database_path('data/quiz_10.json'));
    }

    public function importQuiz(string $path): void
    {
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $quiz = Quiz::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $questionSortOrder = 0;
        foreach ($data['quiz'] as $questions) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $questions['question'],
                'type' => QuestionType::tryFrom($questions['type']),
                'sort_order' => $questionSortOrder++,
            ]);

            $optionSortOrder = 0;
            foreach ($questions['options'] as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'text' => $option['text'],
                    'is_correct' => $option['is_correct'] ?? false,
                    'sort_order' => $optionSortOrder++,
                    'points' => $option['is_correct'] ? $option['points'] : 0,
                ]);
            }
        }
    }
}
