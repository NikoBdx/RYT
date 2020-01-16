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
  public function store(Request $request)
  {

  }


  public function create($id)
  {
      $orders = Order::all();

      return view('orders.create', compact('orders'));
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */

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
