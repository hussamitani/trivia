<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return view('pages.quizzes', ['quizzes' => Quiz::all()]);
    }

    public function show(Quiz $quiz, Request $request)
    {

        return Quiz::query()->where('id', $quiz->id)
            ->with('attempts', function (HasMany $query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->with('questions.options')
            ->first();

    }
}
