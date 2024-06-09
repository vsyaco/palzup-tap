<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_telegram_id_index');
            $table->dropColumn('telegram_id');
            $table->dropColumn('telegram_username');
            $table->dropColumn('telegram_first_name');
            $table->dropColumn('telegram_last_name');
            $table->dropColumn('telegram_language_code');
            $table->dropColumn('score_last_update');
            $table->dropColumn('score_1h');
            $table->dropColumn('score_24h');
            $table->dropColumn('score_7d');
            $table->dropColumn('score_30d');
            $table->dropColumn('score_all');
        });

        Schema::create('telegram_users', function (Blueprint $table) {
            $table->id();
            $table->integer('telegram_id');
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('language_code');
            $table->dateTime('score_last_update');
            $table->integer('score_1h');
            $table->integer('score_24h');
            $table->integer('score_7d');
            $table->integer('score_30d');
            $table->integer('score_all');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_users');
    }
};
