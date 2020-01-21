@extends('layouts.app')
@section('content')

<h1 class="text-center mb-5">Bonjour {{Auth::user()->firstname}}</h1>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
      aria-controls="nav-home" aria-selected="true">Disponible(s)</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
      aria-controls="nav-profile" aria-selected="false">En cours</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
      aria-controls="nav-contact" aria-selected="false">Terminée(s)</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">@foreach ($orders as $order)
  <div class="card  mb-2">
    <div class="row no-gutters">
      <div class="col-md-3"">
                  <img src=" {{$order->tool->image}}" class="card-img-top h-100 p-2" alt="...">
      </div>
      <div class="col-md-6">
        <div class="card-body">
          <h5 class="card-title">{{$order->tool->title}}</h5>
          <h5 class="card-title">{{$order->renter->town}} ({{$order->renter->cp}})</h5>
          <p class="card-text">Alice is a freelance web designer and developer based in London. She is specialized in
            HTML5, CSS3, JavaScript, Bootstrap, etc.</p>
        </div>
      </div>
      <div class="col-md-3 row align-items-center">
        <div class="col text-center">
          <a class="btn btn-primary" href="/map/{{ $order->id }}">Réserver cette course</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach</div>







  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
</div>




@endsection
