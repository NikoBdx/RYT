<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use User;
use Redirect;
use Validator;
use UploadedFile;
use App\Model\Tool;
use App\Model\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;



class ToolController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth')->only(['create', 'store']);
      }

    public function index()
    {

      $tools = Tool::orderBy('created_at', 'desc')->paginate(5);

        return view('tools.index', compact('tools'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
      $categories = Category::all();

      return view('tools.create', compact('categories'));
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
        'price' => 'required|integer',
        'categories' => 'required',
        'image' => 'required'
      ];
      $validator = Validator::make($values, $rules,[
        'decription.required' => 'La decription est obligatoire',
        'title.required' => 'Le titre est obligatoire',
        'price.required' => 'Veuillez saisir un prix',
        'image.required' => 'L\'image est obligaotire',
        'categories.required' => 'Merci de choisir au moins une catégorie'
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
      $image_resize->save(public_path('storage/' .$name));
      $tool = new Tool();
      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $name;
      $tool->user_id = $user_id;

      if ($tool->save()){
                        $tool->categories()->attach($request->categories);
                    };

      return redirect()->route('tools.index');

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
