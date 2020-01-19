<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use User;
use File;
use Redirect;
use Validator;
use UploadedFile;
use App\Model\Tool;
use App\Model\Category;
use App\Model\Category_tool;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
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
        'description' => 'required|string|min:10',
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
      $image_resize->resize(400, 400);
      $name = md5(uniqid(rand(), true)). '.' . $image->getClientOriginalExtension();
      $newPath = public_path('/storage/');
            if (!file_exists($newPath)) {
                File::makeDirectory($newPath, $mode = 0777, true, true);
            }
      $image_resize->save(($newPath .$name));
      $tool = new Tool();
      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $name;
      $tool->user_id = $user_id;

      if ($tool->save()){
        $tool->categories()->attach($request->categories);
      };

      return redirect()->route('welcome')->with('success', 'Votre outils a bien été ajouté');

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Tool $tool)
  {
    return view('tools.show', compact('tool'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //dd($id);
    $categories = Category::all();
    $tool = Tool::find($id);

    return view('tools.edit')->with('tool', $tool)
                             ->with('categories',$categories);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request ,$id)
  {
    $values = $request->all();

    $rules = [
      'description' => 'required|string|min:10',
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
    $image_resize->resize(400, 400);
    $name = md5(uniqid(rand(), true)). '.' . $image->getClientOriginalExtension();
    $newPath = public_path('/storage/');
            if (!file_exists($newPath)) {
                File::makeDirectory($newPath, $mode = 0777, true, true);
            }
      $image_resize->save(($newPath .$name));

    $tool = Tool::find($values['id']);

      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $name;

    if ($tool->save()){
      $cat_to_delete = Category_tool::where('tool_id', $values['id'])->delete();

      $tool->categories()->attach($request->categories);
    };
    return redirect()->route('tools.show', $tool->id )->with('success', 'Votre outils a bien été modifié');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    return view('tools.show', compact('tool'));
  }


  public function search(Request $request){

    if( $request->ajax() ){
      
      $output = '';
      // Requete SQL
      $list = Tool::where('title','LIKE', '%'.$data.'%')->take(4);
      // Boucle sur requete SQL
      foreach ($list as $key ) {
        //Creer HTML necessaire 
        $output .= " ";
      }

      return response($output);
    }
    
    $data = $request->input('q');

    if ( $request->input('category') !== null ) {
      $category_id = $request->input('category');
      $tools = Tool::where('title','LIKE', '%'.$data.'%' )
              ->join('category_tool', 'tools.id', '=', 'category_tool.tool_id')
              ->where('category_tool.category_id',$category_id)
              ->paginate(5);
    } else {
      $tools = Tool::where('title','LIKE', '%'.$data.'%' )->paginate(5);
    }


    return  view('tools.index')->with('tools', $tools);




    }

    public function list(){
        $categories = Category::all();
        return view('/tools/search')->with('categories', $categories);
    }

    public function showFromNotification(Tool $tool, DatabaseNotification $notification)
    {
      $notification->markAsRead();
      return view('tools.message', compact('tool'));
    }

}

?>
