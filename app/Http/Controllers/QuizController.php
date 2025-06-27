<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class QuizController extends Controller
{
    public function index(): View|Application|Factory
    {
        return view('pages.quizzes', ['quizzes' => Quiz::all()]);
    }
}
