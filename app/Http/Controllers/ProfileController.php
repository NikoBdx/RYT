<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Model\Tool;
use App\Model\User;
use App\Model\Category;
use App\Model\Category_tool;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function myprofile()
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $tools = Tool::where('user_id', $user_id)->get();
            return view('profile.profile')
                ->with('user', $user)
                ->with('tools', $tools);
    }

    public function profiledit(Request $request, $user_id)
    {
        $user= Auth::user();
        return view('profile.profile-edit')->with('user', $user);
    }
    

    public function profileupdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->cp = $request->input('cp');
        $user->town = $request->input('town');
        $user->update();

        return redirect('profile')->with('success', 'Le profil a été mis à jour');
    }

    public function profiledelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('profile')->with('success', 'Votre compte et vos annonces ont été supprimés.');
    }

    public function mypostedit(Request $request, $id)
    {
        $categories = Category::all();
        $tool = Tool::findOrFail($id);
        return view('profile.mypost-edit')
                ->with('tool', $tool)
                ->with('categories', $categories);
    }


    public function mypostupdate(Request $request, $id)
    {
        $image = $request->file('image');
        $name = $request->file('image')->getClientOriginalName();
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => 300, "height"=>300]);

        $tool = Tool::find($id);
        $tool->title = $request->input('title');
        $tool->description = $request->input('description');
        $tool->price = $request->input('price');
        $tool->image = $image_url;
        $tool->update();


        if ($tool->save()){
        $cat_to_delete = Category_tool::where('tool_id', $request->input('id'))->delete();

        $tool->categories()->attach($request->categories);
        };

        return redirect('profile')->with('success', 'L\'annonce a été mise à jour');
    }

}
