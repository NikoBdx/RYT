<?php

namespace App\Http\Controllers;

use App\Model\Tool;
use App\Model\Order;
use App\Model\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */

  public function index()
  {

    $orders_start = Order::where('status', 'start')->latest()->get();
    dd($orders_start);
    $orders_pending = Order::where('status', 'pending')->latest()->get();
    return view('drivers.courses', compact('orders_start', 'orders_pending'));
  }

  public function order(Order $order)
  {
    $order->status = 'pending';
    $order->driver_id = Auth::user()->id;
    $order->save();
    return view('drivers.order', compact('order'));
  }

  public function done($id)
    {
        $order_done = Order::where('id', ($id))->get();
        $order_done->status = 'done';
        $order_done->save();
        return redirect('/')->with('success', 'L\'utilisateur a été supprimé.');
    }

   public function show_map($id)
    {
       return view("drivers/$id");
    }

    /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('drivers.create');
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
