@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">

      <img class= "img-fluid mx-auto d-block" src='{{asset("/img/RYT-logo-medium.png")}}' alt="logo">            

    </div>
</div>

<div class="text-center mt-3"><h1>Les Derniers Outils Proposés</h1></div>
<div class="card-deck mt-3">
  @foreach ( $tools as $tool)
  <div class="card">
    <img class="card-img-top" src='{{asset("/storage/{$tool->image}")}}' alt="{{$tool->title}}">
    <div class="card-body">
      <h5 class="card-title">{{$tool->title}}</h5>
      <p class="card-text">{{$tool->description}}</p>
    </div>
    <div class="card-footer">
      @foreach($tool->categories as $category)
        <span class="categories">{{ $category->name }} </span>
      @endforeach
    </div>
  </div>
  @endforeach
</div>

@endsection
