<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Model\Tool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function registered()
    {
        $users = User::all();
        return view('admin.user-register')
                ->with('users', $users);                  
    }

    public function posted()
    {
        $tools = Tool::all();
        return view('admin.post-register')
                ->with('tools', $tools);  
    }

    public function registeredit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('admin.user-edit')->with('users', $users);
    }

    public function postedit(Request $request, $id)
    {
        $tools = User::findOrFail($id);
        return view('admin.post-edit')->with('tools', $tools);
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

        return redirect('user-register')->with('status', 'L\'utilisateur a été mis à jour');
    }

    public function registerdelete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('user-register')->with('status', 'L\'utilisateur a été supprimé.');
    }

    public function postdelete($id)
    {
        $tools = Tool::findOrFail($id);
        $tools->delete();

        return redirect('post-register')->with('status', 'L\'annonce a été supprimée.');
    }   




}


