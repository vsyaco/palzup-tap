<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TelegramUserController extends Controller
{
    public function show($telegramId)
    {
        $telegramUser = TelegramUser::select('score_all')->whereTelegramId($telegramId)->first();
        return response()->json([
            'score_all' => $telegramUser->score_all,
        ]);
    }
}
