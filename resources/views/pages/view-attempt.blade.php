@extends('layouts.app')
@section('content')
    <div class="container my-4 max-w-2xl mx-auto">
        <br>
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="mb-2 card-title text-3xl text-center">{{ $attempt->quiz->title }}</h1>
                <p class="mb-0"><strong>User:</strong> {{ $attempt->user->name }}</p>
                <p class="mb-0"><strong>Score:</strong> {{ round($attempt->final_score, 2) }} / {{ round($attempt->quiz->questions->pluck('options')->flatten()->sum('points')) }}</p>
                <p class="mb-0"><strong>Time:</strong> {{ $attempt->started_at->diff($attempt->ended_at)->format('%H:%I:%S') }}</p>
            </div>
        </div>
        <hr>
        <br>

        @foreach($attempt->quiz->questions as $index => $question)
            @php
                $userChoices = $attempt->choices->where('question_id', $question->id);
                $isMultiple = $question->type->value === 'multiple';
            @endphp
            <div class="mb-8">
                <div class="font-semibold mb-4 text-lg">
                    Question {{ $index + 1 }} of {{ $attempt->quiz->questions->count() }}
                    <span class="text-sm font-light">({{$question->options->sum('points')}} points)</span>
                </div>
                <div class="mb-3 text-2xl">{{ $question->text }}</div>
                <div class="flex flex-col gap-3">
                    @foreach($question->options as $option)
                        @php
                            $choice = $attempt->choices->where('question_id', $question->id)->first();
                            $isSelected = in_array($option->id, $choice->selected_options);
                            $isCorrect = $option->is_correct;
                            $btnClasses = 'w-full px-4 py-2 rounded border text-left cursor-default flex items-center gap-2 ';
                            if($isSelected && $isCorrect) {
                                $btnClasses .= 'bg-green-700 text-white border-green-800';
                            } elseif($isCorrect) {
                                $btnClasses .= 'bg-green-500 text-white border-green-700';
                            } elseif($isSelected) {
                                $btnClasses .= 'bg-yellow-600 text-white border-blue-700 border-2 border-red-500';
                            } else {
                                $btnClasses .= 'bg-white text-gray-800 border-gray-300';
                            }
                        @endphp
                        <button type="button" class="{{ $btnClasses }}" disabled>
                            <span>{{ $option->text }}
                                <span class="text-xs">
                                    @if($isSelected && $isCorrect)
                                        (+{{$option->points}} point)
                                    @elseif($isCorrect)
                                        ({{$option->points}} point missed)
                                    @elseif($isSelected)
                                        (-1 point)
                                    @endif
                                </span>
                            </span>
                            @if($isSelected && $isCorrect)
                                <span class="ml-auto badge">Correct choice ✅</span>
                            @elseif($isCorrect)
                                <span class="ml-auto badge">Actual ☑️</span>
                            @elseif($isSelected)
                                <span class="ml-auto badge">Your choice ⛔</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
