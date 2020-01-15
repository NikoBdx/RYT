<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'password', 'vehicule'
    ];
}
