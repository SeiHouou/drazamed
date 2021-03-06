<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Customer;
use App\Professional;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Corresponding Customer Details
     * @return mixed
     */
    public function customer()
    {
        return $this->hasOne('App\Customer',  'mail', 'email');

    }


    /**
     * Corresponding Customer Details
     * @return mixed
     */
    public function professional()
    {
        return $this->hasOne('App\Professional', 'id', 'user_id');
    }

    /**
     * Realtime Messages
     * A user can have many messages
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
