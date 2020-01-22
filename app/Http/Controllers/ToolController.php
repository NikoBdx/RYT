<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Mail;
use User;
use Redirect;
use Validator;
use UploadedFile;
use App\Model\Tool;
use App\Model\Category;
use App\Model\Category_tool;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Notifications\DatabaseNotification;
use Intervention\Image\ImageManagerStatic as Image;
use App\Upload;

class ToolController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth')->only(['create', 'store', 'show', 'edit', 'update', 'destroy']);
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
      $name = $request->file('image')->getClientOriginalName();
      $image_name = $request->file('image')->getRealPath();
      Cloudder::upload($image, null);
      list($width, $height) = getimagesize($image_name);
      $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => 300, "height"=>300]);

      $tool = new Tool();
      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $image_url;
      $tool->user_id = $user_id;

      if ($tool->save()){
        $tool->categories()->attach($request->categories);
      };

      return redirect()->route('profile')->with('success', 'Votre outils a bien été ajouté');

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
      $name = $request->file('image')->getClientOriginalName();
      $image_name = $request->file('image')->getRealPath();
      Cloudder::upload($image, null);
      list($width, $height) = getimagesize($image_name);
      $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => 300, "height"=>300]);


      $tool = Tool::find($values['id']);

      $tool->title = $values['title'];
      $tool->description = $values['description'];
      $tool->price = $values['price'];
      $tool->image = $image_url;

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

      $output = '<div class="container ">';

      // Requete SQL
      $list = Tool::where('title','LIKE', '%'.$_GET['q'].'%')->take(3)->get();
      // Boucle sur requete SQL
      //dd($list);
      foreach ($list as $key ) {

        //Creer HTML necessaire
        $output .= "  <a href=\"/tools/$key->id\">
                        <div class=\"row h-50\">
                            <div class=\"col-6 p-2 h-160\" >
                                <p>$key->title  | $key->price</p>
                                <p>$key->description</p>
                            </div>
                            <div class=\"col-6 p-2 h-160\"><img class=\"float-right\" src=\"$key->image\" alt=\"image\" height=\"150\"></div>
                        </div>
                    </a>";

      }
      $output .= "</div> ";


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
