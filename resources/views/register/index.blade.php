@extends('layouts.app')
@section('content')
<div class="container">
        <h1 class="text-center mb-5">Choisissez votre type d'inscription</h1>

                <div class="row">
                        <div class="col-md-6 text-center">
                                <div class="mb-3">
                                        <a href="{{ route('register') }}"><i class="icon-register fas fa-user"></i></a>
                                </div>
                                <p>Utilisateur</p>
                        </div>
                        <div class="col-md-6 text-center">
                        <div>
                                <div class="mb-3">
                                        <!-- <a href="{{-- route('drivers/register') --}}"><i class="icon-register fas fa-truck"></i></a> -->
                                </div>
                                <p>Livreur</p>
                        </div>


                        </div>
                </div>
        </div>
@endsection
