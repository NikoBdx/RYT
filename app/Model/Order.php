<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Payment;
use App\Model\User;
use App\Model\Tool;


class Order extends Model
{
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function tools()
    {
        return $this->hasOne(Tool::class);
    }

    public function payments()
    {
      return $this->hasOne(Payment::class);
    }
}
