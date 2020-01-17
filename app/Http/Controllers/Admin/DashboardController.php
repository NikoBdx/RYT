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

    public function registeredit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('admin.register-edit')->with('users', $users);
    }

    public function registerupdate(Request $request, $id)
    {
        $users = User::find($id);
        $users->firstname = $request->input('firstname');
        $users->lastname = $request->input('lastname');
        $users->email = $request->input('email');
        $users->address = $request->input('address');
        $users->cp = $request->input('cp');
        $users->town = $request->input('town');
        $users->role = $request->input('role');
        $users->update();

        return redirect('role-register')->with('status', 'L\'utilisateur a été mis à jour');
    }

    public function registerdelete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('role-register')->with('status', 'L\'utilisateur a été supprimer');
    }


}


