<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userContacts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','city','street','zip_code','country'
    ];
}
