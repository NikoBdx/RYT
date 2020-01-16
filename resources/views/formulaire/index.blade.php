@extends('layouts.app')
@section('content')
@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h2>Votre adresse de messagerie ne sera pas publiée. Les champs obligatoires sont indiqués avec *</h2>
            <form action="" method="post">
                @csrf
                <div class="form-group">
                <label for="email">Votre adresse email*</label>
                <input type="text" name="email" id="email" class="form-control {{ $errors->has('email') ? ' has-error ' : ''}}" value="{{ old('email') }}">
                </div>

                @if($errors->has('email'))
                    <span class="alert alert-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <div class="form-group">
                <label for="lastname">Votre nom*</label>
                <input class="form-control" type="text" name="lastname" id="lastname">
                </div>

                <div class="form-group">
                <label for="firstname">Votre prénom*</label>
                <input class="form-control" type="text" name="firstname" id="firstname">
                </div>

                <div class="form-group">
                <label for="message">Votre message*</label>
                <textarea class="form-control" name="message" id="message" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                <button>Envoyer</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection



