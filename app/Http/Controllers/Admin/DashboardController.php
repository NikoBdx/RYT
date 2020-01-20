<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use File;
use App\Model\Tool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Category_tool;
use Intervention\Image\ImageManagerStatic as Image;

class DashboardController extends Controller
{
    public function registered()
    {
        $tools = Tool::all();
        $users = User::all();
        $usersinc = User::all()->sortBy('lastname');
        $usersdesc = User::all()->sortBy('lastname');
        return view('admin.user-register')
                ->with('users', $users)
                ->with('usersinc', $usersinc)
                ->with('usersdesc', $usersdesc)
                ->with('tools', $tools);
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
        $categories = Category::all();
        $tool = Tool::findOrFail($id);
        return view('admin.post-edit')
                ->with('tool', $tool)
                ->with('categories', $categories);
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

        return redirect('user-register')->with('success', 'L\'utilisateur a été mis à jour');
    }

    public function registerdelete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('user-register')->with('success', 'L\'utilisateur a été supprimé.');
    }

    public function postdelete($id)
    {
        $tools = Tool::findOrFail($id);
        $tools->delete();

        return redirect('post-register')->with('success', 'L\'annonce a été supprimée.');
    }

    public function postupdate(Request $request, $id)
    {
        $image = $request->file('image');
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(400, 400);
        $name = md5(uniqid(rand(), true)). '.' . $image->getClientOriginalExtension();
        $newPath = public_path('/storage/');
            if (!file_exists($newPath)) {
                File::makeDirectory($newPath, $mode = 0777, true, true);
            }
      $image_resize->save(($newPath .$name));

        $tool = Tool::find($id);
        $tool->title = $request->input('title');
        $tool->description = $request->input('description');
        $tool->price = $request->input('price');
        $tool->image = $name;
        $tool->update();


        if ($tool->save()){
        $cat_to_delete = Category_tool::where('tool_id', $request->input('id'))->delete();

        $tool->categories()->attach($request->categories);
        };

        return redirect('post-register')->with('success', 'L\'annonce a été mise à jour');
    }

    public function data()
    {
        $tools = Tool::all();
        $users = User::all();
        $lasttool = Tool::orderBy('id', 'desc')->take(1)->get();
        $lastuser = User::orderBy('id', 'desc')->take(1)->get();

        return view('admin.dashboard')
                ->with('users', $users)
                ->with('tools', $tools)
                ->with('lastuser', $lastuser)
                ->with('lasttool', $lasttool);
    }

}


