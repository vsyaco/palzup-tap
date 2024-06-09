@extends('telegram-webapp::main')

@section('lang', 'en')

@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @csrf
@endsection

@section('title', 'Palzup Tap')

@section('content')
    <div id="app-content">
        <div class="game-container">
            <h1>Palzup Tap</h1>
            <div class="score-board">
                <span id="points">0</span>
            </div>
            <div class="chain-container" id="chainImage"></div>
            <div class="boosts">
                <span>Boost: <span id="boostValue"></span></span>
            </div>
            <div class="progress-container">
                <div id="boostProgress" class="progress-bar"></div>
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('scores.index') }}" class="inline-block mt-16 mb-4 px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                Scores
            </a>
        </div>
    </div>
@endsection
