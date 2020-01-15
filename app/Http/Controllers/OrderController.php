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
use Intervention\Image\ImageManagerStatic as Image;

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
    return view('order.index');
  }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function store(Request $request)
  {

    $tool_id = $tool->id;

    $values = $request->all();

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
      $orders = Order::all();

      return view('orders.create', compact('orders'));
    
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