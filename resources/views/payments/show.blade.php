@extends('layouts.app')
@section('content')

    <div class="container">

        <div class="row p-5 m-5 d-flex justify-content-center">
            <h1 class="text-center">Votre commande a bien été prise en compte</h1>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 text-center my-2">
                <form action="{{ route('payments.export')}}" method="GET">
                    <input type="hidden" name="id" value="{{$payment->id}}">
                    <button type="submit" class="btn btn-primary">Exporter au format PDF</button>
                </form>
            </div>
            <div class="col-md-6 col-sm-12 text-center my-2">
                <a href="/profile" class="btn btn-primary">Votre Profil</a>
            </div>
        </div>
    </div>

@endsection
