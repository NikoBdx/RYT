@extends('layouts.app')

@section('title')
Edition profil utilisateur | RYT
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class ="text-center">Edition du profil</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/profile-update/{{$user->id}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>email</label>
                                <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Adresse</label>
                                <input type="text" name="address" value="{{ $user->address }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Code Postal</label>
                                <input type="text" name="cp" value="{{ $user->cp }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" name="town" value="{{ $user->town }}" class="form-control">
                            </div>
                                                        
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Enregistrer la modification</button>
                                <a href="/profile" type="submit" class="btn btn-danger">Annuler la modification</a>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection