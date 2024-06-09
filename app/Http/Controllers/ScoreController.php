<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{

    public function index()
    {
        $scores = TelegramUser::orderBy('score_all', 'desc')->limit(10)->get();

        return view('scores', compact('scores'));
    }

    public function update(Request $request)
    {
        $user = TelegramUser::whereTelegramId($request->input('user.id'))->first();

        if ($user === null) {
            $score = $request->input('score') > 6 ? 6 : $request->input('score');
            TelegramUser::create([
                'telegram_id' => $request->input('user.id'),
                'username' => $request->input('user.username'),
                'first_name' => $request->input('user.first_name'),
                'last_name' => $request->input('user.last_name'),
                'language_code' => $request->input('user.language_code'),
                'score_last_update' => now(),
                'score_1h' => $score,
                'score_24h' => $score,
                'score_7d' => $score,
                'score_30d' => $score,
                'score_all' => $score,
            ]);

            return response()->json();
        }

        // Compare last_update_time with current time if score_last_update is null then it's now minus 6 seconds
        $lastUpdateTime = $user->score_last_update ?? now()->subSeconds(6);
        $currentTime = now();
        $diff = $currentTime->diffInSeconds($lastUpdateTime)+1;
        $score = $request->input('score');

        // Update score if score isn't higher than 6*$diff

//        if ($score > 6*$diff) {
//            abort(422);
//        }

        DB::table('telegram_users')
            ->where('telegram_id', $request->input('user.id'))
            ->incrementEach([
                'score_1h' => $score,
                'score_24h' => $score,
                'score_7d' => $score,
                'score_30d' => $score,
                'score_all' => $score
            ], [
                'score_last_update' => now(),
                'username' => $request->input('user.username'),
                'first_name' => $request->input('user.first_name'),
                'last_name' => $request->input('user.last_name'),
                'language_code' => $request->input('user.language_code'),
            ]);

        return response()->json();
    }
}
