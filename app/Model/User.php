<?php

namespace App\Model;

use App\Model\Tool;
use App\Model\Vehicule;
use App\Model\Payment;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','address','cp','town', 'email', 'password', 'role', 'vehicule', 'latitude', 'longitude'
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

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
