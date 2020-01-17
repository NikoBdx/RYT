@extends('layouts.app')
@section('content')
<div class="banner-project-show">
    <h1 class="card-title text-center mb-3">{{$tool->title}}</h1>
</div>
<div class="container">
  <div class="text-center mb-3">
  <img class="img-fluid" src='{{asset("/storage/{$tool->image}")}}' alt="image-tool">
  </div>
    <div class="row">
        <div class="col col-12 col-sm-12 col-md-9 mb-3">
            <div class="card card-project">
                <div class="card-body">
                    <p class="card-text">{{ $tool->description }}</p>
                   <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td scope="row">Publié le</td>
                                <th colspan="2">{{Carbon\Carbon::parse($tool->created_at)->isoFormat('LL')}}</th>
                            </tr>
                            <tr>
                                <td scope="row">Prix</td>
                            <th colspan="2">{{$tool->price}} €/jour</th>
                            </tr>
                            <tr>
                                <td scope="row">Localisation</td>
                                <th colspan="2">{{$tool->user->town}} ({{$tool->user->cp}})</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col col-12 col-sm-12 col-sm-12 col-md-3 ">

                @if ( !empty(Auth::user()) && Auth::user()->id === $tool->user->id)
                <p class="card-text">Vous êtes le propriétaire de cet outil</p>
                <div class="card card-project mb-5">
                    <a class="btn btn-warning" href="/tools/{{$tool->id}}/edit">Modifier mon outils</a>

                </div>
                <div class="card card-project mb-5">
                    <form action="{{ route('comments.show')}}" method="POST">
                     @csrf
                        <input type="hidden" name="tool_id" value="{{$tool->id}}">
                        <div class="card card-project">
                            <button class="btn btn-primary">Voir les messages</button>
                        </div>
                    </form>
                </div>
                @else


                <p class="card-text"></p>
                <div class="card card-project mb-5">
                    <form action="{{ route('comments.show')}}" method="POST">
                     @csrf
                        <input type="hidden" name="tool_id" value="{{$tool->id}}">
                        <div class="card card-project">
                            <button class="btn btn-primary">Contacter le loueur</button>
                        </div>
                    </form>
                </div>
                <div class="card card-project">
                    <a class="btn btn-success" href="/orders/{{ $tool->id }}">Réserver cet outil</a>
                </div>

                @endif

        </div>
    </div>
</div>
@endsection
