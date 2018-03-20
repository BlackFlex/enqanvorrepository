<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmailSettings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','message_from_adv','adv_response','special_offers','daily_horo',  'weekly_horo','monthly_horo','monthly_career_horo','articles_news_updates'
    ];
}
