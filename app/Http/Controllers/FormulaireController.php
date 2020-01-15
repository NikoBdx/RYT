<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Formulaire;
use App\Model\Formulaire as Form;
use Mail;
use Redirect;
use Validator;

class FormulaireController extends Controller
{
    public function index()
    {
        return view('formulaire.index');
    }

    public function store(Request $request)
    {
        $values = $request->all();
        $rules = [
            'email' => 'email|required',
            'lastname' => 'string',
            'firstname' => 'string',
            'message' => 'string'
        ];

       $validator = Validator::make($values, $rules,[
        'email.email' => 'Votre e-mail est invalide',
        'email.required' => 'Votre e-mail est obligatoire',
        'lastname.string' => 'Votre nom ne doit pas comporter de caratère spécial',
        'firstname.string' => 'Votre prénom ne doit pas comporter de caratère spécial',
        'message.string' => 'Votre message ne doit pas comporter de caractère special'
       ]);

       if($validator->fails()){
           return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
       }
       // on crée une nouvelle entrée
       $formulaire = new Form();
      
       $formulaire->email = $values['email'];
       $formulaire->lastname = $values['lastname'];
       $formulaire->firstname = $values['firstname'];
       $formulaire->message = $values['message'];
       $formulaire->ip_address = $_SERVER['REMOTE_ADDR'];
       
       $formulaire->save();


       // Transfert de l'e-mail
       $title = 'Formulaire de contact';
       $content = $values['lastname'] . '-' . $values['firstname'] . '<br>' . $values['message'];

       Mail::to($values['email'])->send(new Formulaire($title, $content));

       return view('formulaire.index')
                ->with('successMessage', 'Message envoyé !');

    }
}
