<?php

namespace App\Http\Controllers;

use App\Model\Tool;
use App\Model\User;
use App\Model\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{

    public function create(Request $request)
    {
        $client_id = Auth::user()->id;
        $messages = Message::where('tool_id', $request->tool_id)->where('client_id', $client_id)->get();
        $renter = User::where('id', $request->renter_id)->first();
        $tool = Tool::where('id', $request->tool_id)->first();

        return view('messages.create', compact('renter', 'tool', 'messages'));
    }


    public function store(Request $request)
    {
      $messages = Message::where('tool_id', $request->tool_id)->get();
      $client_id = Auth::user()->id;
      $values = $request->all();
      $rules = [
        'content' => 'required|string|min:10',
      ];

      $validator = Validator::make($values, $rules,[
        'content.required' => 'Veuillez écrire un message',
      ]);

      if($validator->fails()){
      return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      }

      $message = new Message();
      $message->renter_id = $values["renter_id"];
      $message->tool_id = $values["tool_id"];
      $message->client_id = $client_id;
      $message->content = $values["content"];

      $message->save();

    //   return redirect() ->route('tools.show', $values["tool_id"])
    //                     ->with('success', 'Votre message a bien été envoyé');
    return Redirect::back()->with('success', 'Votre message a bien été envoyé');

    }
}
