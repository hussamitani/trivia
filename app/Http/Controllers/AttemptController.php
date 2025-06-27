<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function new(Quiz $quiz, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory
    {
        $quiz
            ->load('questions.options')
            ->load(['attempts' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }])
            ->with('questions.options')
            ->first();

        return view('pages.new-attempt', compact('quiz'));
    }

    public function view(Attempt $attempt)
    {
        $attempt->load('quiz')->load('choices.question');

        return view('pages.view-attempt', compact('attempt'));
    }
}
