@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
                <a href="{{ url('quizzes/' . $quiz->id . '/attempt') }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200 p-6 border border-gray-100 hover:border-blue-400">
                    <h5 class="text-xl font-semibold mb-2 text-gray-800">{{ $quiz->title }}</h5>
                    <p class="text-gray-600">{{ $quiz->description }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
