<?php

namespace Model\Tool;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model 
{

    protected $table = 'tools';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('User');
    }

}