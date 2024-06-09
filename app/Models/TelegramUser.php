<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{

    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'language_code',
        'score_last_update',
        'score_1h',
        'score_24h',
        'score_7d',
        'score_30d',
        'score_all',
    ];

    protected function casts()
    {
        return [
            'score_last_update' => 'datetime',
        ];
    }

    protected $appends = ['publicName'];

    //Add name attribute: if first_name only, return first_name, if first_name and last_name, return first_name last_name, if no first_name, return username
    protected function publicName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->username) {
                    return trim($this->username);
                }
                if ($this->first_name && $this->last_name) {
                    return trim($this->first_name) . ' ' . trim($this->last_name);
                }
                if ($this->first_name) {
                    return $this->first_name;
                }
                if ($this->last_name) {
                    return $this->last_name;
                }

                return 'Unknown';
            }
        );
    }
}
