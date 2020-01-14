@extends('layouts.app')
@section('content')
        <h1 class="text-center">Choisissez votre type d'inscription</h1>
        <div class="container">
                <div class="row">
                        <div class="col-md-6">
                                <a href="{{ route('register') }}">Utilisateur</a>
                                <small>Vous souhaitez louer ou mettre location</small>                           
                        </div>
                        <div class="col-md-6">
                                <a href="#">Livreur</a>
                                <small>Vous souhaitez vous inscrire en tant que livreur</small>
                        </div>
                </div>
        </div>
@endsection
