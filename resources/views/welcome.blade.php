<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Palzup Tap</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="game-container">
            <h1>Palzup Tap</h1>
            <div class="score-board">
                <span id="points">0</span>
            </div>
            <div class="chain-container">
                <img id="chainImage" src="{{ asset('storage/palzup.jpg') }}" alt="chain" class="chain-image">
            </div>
            <div class="boosts">
                <span>Boost: <span id="boostValue">1x</span></span>
            </div>
            <div class="progress-container">
                <div id="boostProgress" class="progress-bar"></div>
            </div>
        </div>
    </body>
</html>
