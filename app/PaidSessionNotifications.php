<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidSessionNotifications extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expert_id','session_notification_id','rate','text','status'
    ];
}
