@extends('layouts.app')
@section('content')

<h1 class="text-center mb-5">Bonjour {{Auth::user()->firstname}}</h1>


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Disponible<span class="ml-2 {{($orders_start->count() === 0) ? 'numberCircle2' : 'numberCircle'}}"> {{$orders_start->count()}}</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">En cours<span class="ml-2 {{($orders_pending->count() === 0) ? 'numberCircle2' : 'numberCircle'}}"> {{$orders_pending->count()}}</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Terminée<span class="ml-2 {{($orders_done->count() === 0) ? 'numberCircle2' : 'numberCircle'}}"> {{$orders_done->count()}}</span></a>
  </li>
</ul>

{{-- ---------------------------------------- Start -------------------------------------------------- --}}
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    {{dump($orders_start, $orders_pending, $orders_done)}}
    @switch($orders_start->count() >= 0)
      @case($orders_start->count() === 0)
        <h4 class="text-center my-3">Aucune course disponible</h4>
      @break
      @case($orders_start->count() > 0 )
        <h4 class="text-center my-3">Course(s) disponible(s)</h4>
      @break
    @endswitch
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
            </div>
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
{{-- -----------------------------------------Pending-------------------------------------------------- --}}
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    @switch($orders_pending->count() >= 0)
      @case($orders_pending->count() === 0)
        <h4 class="text-center my-3">Aucune course disponible</h4>
      @break
      @case($orders_pending->count() > 0 )
        <h4 class="text-center my-3">Course(s) disponible(s)</h4>
      @break
    @endswitch
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
                <h6 class="card-title">{{$order_pending->renter->town}} ({{$order_pending->renter->cp}}) ---> {{$order_pending->client->town}} ({{$order_pending->client->cp}})</h6>
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
  </div>
{{-- -----------------------------------------Done------------------------------------------------- --}}
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        @switch($orders_done->count() >= 0)
          @case($orders_done->count() === 0)
            <h4 class="text-center my-3">Aucune course terminée</h4>
          @break
          @case($orders_done->count() > 0 )
            <h4 class="text-center my-3">Course(s) terminées</h4>
          @break
        @endswitch
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
                  <h6 class="card-title">{{$order_done->renter->town}} ({{$order_done->renter->cp}}) ---> {{$order_done->client->town}} ({{$order_done->client->cp}})</h6>
                </div>
            </div>
          </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</div>
@endsection
