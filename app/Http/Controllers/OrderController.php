<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use User;
use Redirect;
use Validator;
use UploadedFile;
use App\Model\User as UserAll;
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
  public function index($renter_id)
  {
    $renter = UserAll::find($renter_id);
    $renterLat = $renter->latitude;
    $renterLng = $renter->longitude;
    // dd($renterLat);
    $user = auth()->user();
    $userLon = $user->longitude;
    $userLat = $user->latitude;
    // $orders = Order::all();
    
    // $renter = Coco::where('id', );
    
    return view('geoloc.index', ['userLat' => $userLat, 'userLon' => $userLon, 'renterLat' => $renterLat, 'renterLng' => $renterLng]);
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

    // Create ORDER
    // DUPLICATE PREVENT -> Check if Data with same tool_id and same client_id have been already made in the previous 3 DAYS
    $is_order = Order::where([
                ['tool_id', "=",$tool->id],
                ['client_id', "=",Auth::user()->id],
                ])->whereNotBetween('created_at' , [ date('Y-m-d H:i:s') , date('Y-m-d H:i:s', strtotime('-3 days'))])
                ->exists();
    if( $is_order === true){
      // If find a value take this as the Order for update
      $order = Order::where([
        ['tool_id', "=",$tool->id],
        ['client_id', "=",Auth::user()->id],
        ])->whereNotBetween('created_at' , [ date('Y-m-d H:i:s') , date('Y-m-d H:i:s', strtotime('-3 days'))])
        ->latest('created_at')
        ->first();
    }else{
      //If not create a new Order
      $order = new Order;
    }
    // Insert proper value in the order
    $order->tool_id = $id;
    $order->renter_id = $tool->user_id;
    $order->client_id = Auth::user()->id;
    $order->status = 'Start';

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
