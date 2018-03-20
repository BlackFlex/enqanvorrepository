<?php
/**
 * Created by PhpStorm.
 * User: ооо
 * Date: 12.02.2018
 * Time: 17:31
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Events\ModelCreated;
use Illuminate\Support\Facades\Storage;


class UserPhones extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_phone'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}