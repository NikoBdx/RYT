<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Geocoder\Laravel\Facades\Geocoder;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'cp' => ['required', 'string', 'max:5'],
        'town' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        
        $validator = Validator::make($rules,[
        'firstname.required' => 'Le prénom est obligatoire',
        'lastname.required' => 'Le nom est obligatoire',
        'adress.required' => 'Veuillez saisir l\'adresse',
        'cp.required' => 'Veuillez saisir le code postal',
        'email.required' => 'L\'email est obligatoire'
        ]);

        if($validator->fails()){
        return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      }
      
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {

        $cp = $data['cp'];
        $address = $data['address'];
        $town = $data['town'];

        return User::create([

            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $address,
            'cp' => $cp,
            'town' => $town,
            'email' => $data['email'],
            'role' => $data['role'],
            'vehicule' => $data['vehicule'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'password' => Hash::make($data['password']),

        ]);






    }
}
