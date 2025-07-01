<div>
    @php
        $question = $quiz->questions[$currentQuestion];
        $isMultiple = $question->type->value === 'multiple';
        $selected = $answers[$question->id] ?? ($isMultiple ? [] : null);
        $correctCount = $question->options->where('is_correct', true)->count();
        $selectionLimitReached = $isMultiple && is_array($selected) && count($selected) >= $correctCount;
    @endphp
    <div wire:poll.1s="updateElapsed" class="mb-2 text-right text-gray-500">
        {{ $time }}
    </div>
    <div class="mb-4 text-gray-600 text-center">
        Question {{ $currentQuestion + 1 }} of {{ $quiz->questions->count() }}
    </div>
    <div class="mb-6">
        <div class="font-semibold mb-4 text-center text-3xl">{{ $question->text }}</div>
        @if($isMultiple)
            <div class="text-sm font-light text-center">
                Select a maximum of {{$correctCount}}
            </div>
        @endif
        <br>
        <div class="flex flex-col gap-3">
            @foreach($question->options as $option)
                @php
                    $isSelected = $isMultiple
                        ? in_array($option->id, $selected ?? [])
                        : ($selected == $option->id);
                @endphp
                <button
                    type="button"
                    wire:click="toggleOption({{ $question->id }}, {{ $option->id }})"
                    class="w-full px-4 py-2 rounded border text-left
                    {{ $isSelected ? 'bg-blue-600 text-white border-blue-700' : 'bg-white text-gray-800 border-gray-300 hover:bg-blue-50' }}"
                    @if($selectionLimitReached && !$isSelected) disabled @endif
                >
                    {{ $option->text }}
                </button>
            @endforeach
        </div>
    </div>
    <div class="flex justify-between mt-6">
        <button
            wire:click="previousQuestion"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
            @if($currentQuestion === 0) disabled @endif
        >
            Previous
        </button>
        @if($currentQuestion < $quiz->questions->count() - 1)
            <button
                wire:click="nextQuestion"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Next
            </button>
        @else
            <button
                wire:click="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
            >
                Submit
            </button>
        @endif
    </div>
</div>
