@extends('layouts.app')
@section('content')

    <livewire:new-attempt :quiz_id="$quiz->id" />
@endsection
