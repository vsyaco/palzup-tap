@extends('telegram-webapp::main')

@section('lang', 'en')

@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('title', 'My title')

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
        <p id="user-data">Loading user data...</p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ensure Telegram WebApp is initialized
            Telegram.WebApp.ready();

            // Get user data
            const user = Telegram.WebApp.initDataUnsafe.user;

            if (user) {
                const userInfo = `
                    ID: ${user.id}<br>
                    First Name: ${user.first_name}<br>
                    Last Name: ${user.last_name}<br>
                    Username: ${user.username}<br>
                    Language Code: ${user.language_code}
                `;
                document.getElementById('user-data').innerHTML = userInfo;
            } else {
                document.getElementById('user-data').innerHTML = 'User data not available.';
            }
        });
    </script>
@endsection
