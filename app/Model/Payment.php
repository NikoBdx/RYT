<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Tool;
use App\Model\Order;

class Payment extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tool(){
        return $this->belongsTo(Tool::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
