<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','payment_id','create_time', 'pay_method','status', 'total','currency','description','pay_type','total_money','total_length'
    ];
}
