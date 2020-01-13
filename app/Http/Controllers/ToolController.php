<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;
use App\Model\Tool;
use Redirect;
use UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;


class ToolController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('tools.index');    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $values = $request->all();

              
        $image = $request->file('image');
        
        $image_resize = Image::make($image->getRealPath());              
        $image_resize->resize(600, 300);

        $name = md5(uniqid(rand(), true)). '.' . $image->getClientOriginalExtension(); 

        $image_resize->save(public_path('storage/compagnies/compagny_name/' .$name));

        
        $tool = new Tool();
        $tool->title = $values['title'];
        $tool->description = $values['description'];
        $tool->image = $name;
        
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