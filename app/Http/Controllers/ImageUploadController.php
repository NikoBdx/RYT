<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class ImageUploadController extends Controller
{
    public function uploadImages(Request $request)
   {
       $this->validate($request,[
           'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
       ]);

       $image_name = $request->file('image_name')->getRealPath();;

       Cloudder::upload($image_name, null);

       return redirect()->back()->with('status', 'Image Uploaded Successfully');

   }
}

