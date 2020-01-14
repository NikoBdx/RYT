<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;
use User;
use Auth;
use App\Model\Tool;
use Redirect;
use UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;


class ToolController extends Controller 
{
    public function index()
    {
        return view('tools.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register.driver.index');
    }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)

  {

      $user_id = Auth::user()->id;

      $values = $request->all();

      $rules = [
        'description' => 'required|string',
        'title' => 'required|string',
        'image' => 'required'
      ];

      $validator = Validator::make($values, $rules,[
        'decription.required' => 'La decription est obligatoire',
        'title.required' => 'Le titre est obligatoire',
        'image.required' => 'L\'image est obligaotire'
      ]);

      if($validator->fails()){
      return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      }

           
      $image = $request->file('image');

      $image_resize = Image::make($image->getRealPath());              
      $image_resize->resize(600, 300);

      $name = md5(uniqid(rand(), true)). '.' . $image->getClientOriginalExtension(); 

      $image_resize->save(public_path('storage/tools/' .$name));


      $tool = new Tool();
      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $name;
      $tool->user_id = $user_id;

      $tool->save();  
                      

      return view('tools.index');
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>