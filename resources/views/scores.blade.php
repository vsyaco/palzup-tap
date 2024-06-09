@extends('telegram-webapp::main')

@section('lang', 'en')

@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @csrf
@endsection

@section('title', 'My title')

@section('content')
    <div id="app-content">
        <div class="game-container">
            <h1>Palzup Tap Scores</h1>
            <div class="score-board mt-8">
                @foreach($scores as $user)
                    <span>{{ $user->score_all }} - {{ $user->public_name }}</span>
                @endforeach
            </div>
        </div>
        <div class="text-center">
            <a href="/" class="inline-block mt-16 mb-4 px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
               Play
            </a>
        </div>
    </div>
@endsection
