<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
<header class="sticky top-0 z-30 bg-white/90 backdrop-blur shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-extrabold text-indigo-700 tracking-tight">Quiz App</div>
        <nav class="space-x-6">
            <a href="/quizzes" class="text-gray-700 hover:text-indigo-600 font-medium transition">Quizzes</a>
            <!-- Add more links as needed -->
        </nav>
    </div>
</header>
<main class="flex-1 flex justify-center items-start py-12">
    <div class="w-7xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-indigo-100">
            @yield('content')
        </div>
    </div>
</main>
<footer class="bg-indigo-700 mt-auto">
    <div class="container mx-auto px-6 py-4 text-center text-indigo-100 text-sm">
        &copy; {{ date('Y') }} Quiz App &mdash; All rights reserved.
    </div>
</footer>
@livewireScripts
</body>
</html>
