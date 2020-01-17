<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function registered()
    {
        $users = User::all();
        return view('admin.register')->with('users', $users);
    }
}
