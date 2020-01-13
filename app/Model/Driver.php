<?php

namespace Model\Driver;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model 
{

    protected $table = 'drivers';
    public $timestamps = true;

    public function orders()
    {
        return $this->hasMany('Order');
    }

}