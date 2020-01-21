<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use PDF;
use App\Model\Tool;
use App\Model\User;
use App\Model\Order;
use App\Model\Payment;



class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('toto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = $request->all();
      
        // Get the current Order and Tool

        $order = Order::find($values['idOrder']);
        $tool  = Tool::find($order->tool_id);


        // Date manipulation
        $date = $values['date'].':00';
        if( $date < date('Y-m-d H:i:s',strtotime( ' + 2 days')) ){
            // return view with error message: date must be in 2 days or further
        }
        
        $end_date = date( 'Y-m-d H:i:s',strtotime( $date. ' + '. $values['day']. ' days'));
        
        
        // Adjusting Order value 
        $order->total_price = $tool->price * $values['day'];
        $order->duration = $values['day'];
        $order->start_date =  $date;
        $order->end_date =   $end_date;
        $order->save();
        
        // Create Payment 
        // DUPLICATE PREVENT -> Check if Data with same tool_id and same user_id have been already made in the previous 3 DAYS
        $is_payment =   Payment::where([
                        ['tool_id', "=",$order->tool_id],
                        ['user_id', "=",Auth::user()->id],
                        ])->whereNotBetween('created_at' , [ date('Y-m-d H:i:s') , date('Y-m-d H:i:s', strtotime('-3 days'))])
                        ->exists();
        if( $is_payment === true ){
            // If find a value take this as the payment for update
            $payment = Payment::where([
                        ['tool_id', "=",$order->tool_id],
                        ['user_id', "=",Auth::user()->id],
                        ])->whereNotBetween('created_at' , [ date('Y-m-d H:i:s') , date('Y-m-d H:i:s', strtotime('-3 days'))])
                        ->latest('created_at')
                        ->first();
        }else{
            //If not create a new payment
            $payment = new Payment;
        }
        
        $payment->tool_id = $order->tool_id;
        $payment->user_id = Auth::user()->id;
        $payment->order_id = $order->id;
        $payment->status = "Payer par l'utilisateur";
        $payment->price = $tool->price * $values['day'];

        $payment->save() ;
        
        return view('payments.show')->with('payment', $payment);
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request)
    {
        $values = $request->all();
        $payment = Payment::find($values['id']);

        $pdf = PDF::loadView( 'payments.proof' , array('payment' => $payment))->setPaper('a4');

        return $pdf->download('order_proof.pdf');
    }
}
