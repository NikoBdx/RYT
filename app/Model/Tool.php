<?php

namespace App\Model;

use App\Model\User;
use App\Model\Category;
use App\Model\Category_tool;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
