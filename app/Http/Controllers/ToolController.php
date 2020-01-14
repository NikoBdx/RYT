<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Tool;
use App\Model\Category;
use App\Model\Category_tool;



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
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show()
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

  public function search(Request $request){

    
    $data = $request->input('q');
    $category_id = $request->input('category');
    $categories = Category::all();
    
    $tools = Tool::where('title','LIKE', '%'.$data.'%' )
            ->join('category_tool', 'tools.id', '=', 'category_tool.tool_id')
            ->where('category_tool.category_id',$category_id)
            ->get();
    return  view('/tools/search')->with('tools', $tools)->with('categories',$categories);
    }

    public function list(){
        $categories = Category::all();
        return view('/tools/search')->with('categories', $categories);
    }

}

?>