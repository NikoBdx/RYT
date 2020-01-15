<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
      return $this->belongsToMany(User::class);
    }

    public function tools()
    {
        return $this->hasOne(Tool::class);
    }
}
