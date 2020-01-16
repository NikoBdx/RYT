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
    $user = auth()->user();
    $address = $user->adress . ' ' .  $user->town . ' ' . $user->cp;
    return view('orders.index', ['address' => $address]);
  }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function store(Request $request, $id)
  {

    $values = $request->all();
    dd($values);


    $rules = [
      'duration' => 'required|integer',        
    ];
    
    $validator = Validator::make($values, $rules,[
      'duration.required' => 'La durée de location est obligatoire',
    ]);

    if($validator->fails()){
    return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }

    $order = new Order();
    $order->duration = $values['duration'];
    $order->tool_id = $toolId;
    $order->driver_id = '';
    $order->status = 'Commande en cours';
    $totalPrice = ($values['duration']) * ($tool->price);
    $order->total_price = $totalPrice;
    $order->save(); 


    return redirect()->route('orders.index');



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
  
}
