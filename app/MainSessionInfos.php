<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainSessionInfos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expert_id','user_id',
        'session_length','session_spend_money'
    ];
}
