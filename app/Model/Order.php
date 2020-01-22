<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Payment;
use App\Model\User;
use App\Model\Tool;


class Order extends Model
{

    public function renter()
    {
      return $this->belongsTo(User::class, 'renter_id');
    }

    public function client()
    {
      return $this->belongsTo(User::class, 'client_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }

    public function payments()
    {
      return $this->hasOne(Payment::class);
    }

}
