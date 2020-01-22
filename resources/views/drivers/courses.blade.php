@extends('layouts.app')
@section('content')

<h1 class="text-center mb-5">Bonjour {{Auth::user()->firstname}}</h1>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-start" role="tab"
      aria-controls="nav-home" aria-selected="true">Disponible(s)</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-pending" role="tab"
      aria-controls="nav-profile" aria-selected="false">En cours</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-done" role="tab"
      aria-controls="nav-contact" aria-selected="false">Terminée(s)</a>
  </div>
</nav>

<!-- ---------------------------------- START COMMANDS ---------------------------------- -->
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-start" role="tabpanel" aria-labelledby="nav-home-tab">

@foreach ($orders_start as $order_start)

  <div class="card  mb-2">
    <div class="row no-gutters">
      <div class="col-md-3">
        <img src=" {{$order_start->tool->image}}" class="card-img-top h-100 p-2" alt="...">
      </div>
      <div class="col-md-6">
        <div class="card-body">
          <h5 class="card-title">{{$order_start->tool->title}}</h5>
          <h5 class="card-title">{{$order_start->renter->town}} ({{$order_start->renter->cp}})</h5>
          <p class="card-text text-center"><em>Vous gagnerez pour cette course : ?? €</em></div>
      </div>
      <div class="col-md-3 row align-items-center">
        <div class="col text-center">
          <form action="/drivers/{{ $order_start->id }}"" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Accepter course</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
<!-- ---------------------------------- PENDING COMMANDS ---------------------------------- -->

  <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-profile-tab">

    @foreach ($orders_pending as $order_pending)
    @if (($order_pending->driver_id) === (Auth::user()->id))
      <div class="card  mb-2">
        <div class="row no-gutters">
          <div class="col-md-3">
            <img src=" {{$order_pending->tool->image}}" class="card-img-top h-100 p-2" alt="...">
          </div>
          <div class="col-md-6">
            <div class="card-body">
                <h5 class="card-title">{{$order_pending->tool->title}}</h5>
                <h5 class="card-title">{{$order_pending->renter->town}} ({{$order_pending->renter->cp}})</h5>
                <p class="card-text text-center"><em>Vous gagnerez pour cette course : ?? €</em>
              </div>
          </div>
      <div class="col-md-3 row align-items-center">
        <div class="col text-center">
          <form action="/drivers/{{ $order_pending->id }}"" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Voir la course</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif
  @endforeach
</div>
<!-- ---------------------------------- DONE COMMANDS ---------------------------------- -->
<div class="tab-pane fade" id="nav-done" role="tabpanel" aria-labelledby="nav-profile-tab">
  <h4 class="text-center">Courses terminées</h4>
  @foreach ($orders_done as $order_done)
    @if (($order_done->driver_id) === (Auth::user()->id))
      <div class="card  mb-2">
        <div class="row no-gutters">
          <div class="col-md-3">
            <img src=" {{$order_done->tool->image}}" class="card-img-top h-100 p-2" alt="...">
          </div>
          <div class="col-md-6">
            <div class="card-body">
                <h5 class="card-title">{{$order_done->tool->title}}</h5>
                <h5 class="card-title">{{$order_done->renter->town}} ({{$order_done->renter->cp}})</h5>
                <p class="card-text text-center"><em>Vous gagnerez pour cette course : ?? €</em>
              </div>
          </div>
      <div class="col-md-3 row align-items-center">

      </div>
    </div>
  </div>
  @endif
  @endforeach
</div>

@endsection
