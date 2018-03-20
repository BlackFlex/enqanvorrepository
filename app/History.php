<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    ///type 0 message;
    ///type 1 paid;
    ///type 2 private;

    protected $fillable = [
        'user_id','expert_id','type','time','cost'
    ];
}
