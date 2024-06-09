@extends('telegram-webapp::main')

@section('lang', 'en')

@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('title', 'My title')

@section('content')
    <div id="app-content">
        @php
           dump(\Micromagicman\TelegramWebApp\Facade\TelegramFacade::getWebAppUser(request()));
        @endphp
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
    </div>
@endsection
