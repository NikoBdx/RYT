<?php

namespace Model\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function tool()
    {
        return $this->belongsTo('Tool');
    }

    public function drivers()
    {
        return $this->belongsTo('Driver');
    }

}