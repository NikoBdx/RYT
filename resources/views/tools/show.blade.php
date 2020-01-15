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
                    <p class="card-text">{{$tool->description}}</p>
                   <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td scope="row">Publié le</td>
                                <th colspan="2">{{Carbon\Carbon::parse($tool->created_at)->isoFormat('LL')}}</th>
                            </tr>
                            <tr>
                                <td scope="row">Prix</td>
                            <th colspan="2">{{$tool->price}} €</th>
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
                <div class="card card-project mb-5">
                    <button class="btn btn-primary">Contacter le client</button>
                </div>
                <div class="card card-project">
                    <button class="btn btn-success">Réserver cet outil</button>
                </div>

        </div>
    </div>
</div>
@endsection
