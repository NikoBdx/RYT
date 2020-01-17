<?php 

namespace App\Http\Controllers;

use Auth;
use Mail;
use User;
use Redirect;
use Validator;
use UploadedFile;
use App\Model\Tool;
use App\Model\Order;
use App\Model\Category;
use Illuminate\Http\Request;


class OrderController extends Controller 
{

  public function __construct()
      {
          $this->middleware('auth')->only(['create', 'store']);
      }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function store(Request $request, $id)
  {


  }


  public function create($id)
  {

    
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

    $tool = Tool::find($id);
    //dd($tool);
    $order = new Order;

    $order->tool_id = $id;
    $order->user_id = $tool->user_id;
    if($order->save()){
      return view('orders.show')->with('tool',$tool)->with('order',$order);
    }
  
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

  public function map(Request $request)
  {
    $values = $request->all();

    
    
    $toto = Order::find($values['id']);
    $toto_lat = $toto->user->latitude;
    $toto_long = $toto->user->longitude;

    $user = auth()->user();
    $address = $user->adress . ' ' .  $user->town . ' ' . $user->cp;
    return view('orders.index', ['address' => $address]);

  }
  
}
