@extends('layouts.master')
@section('content')

@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
    <div class="row">
        <h1 class="text-center">Enregistrement des outils</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('tools.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">nom de l'outil</label>
                <input type="text" name="title" id="title">
            </div>

            <div class="form-group">
            <label>Description</label>
            <input type="text" name="description">
            </div>

    <ul>
        @foreach ($tools as $tool)
        <li>
            <div class="card card-project-home mb-3">

                <div class="card-body ">
                    <div class="d-flex">
                        <h2 class="list-project-title">{{$tool->title}} <em class="list-project-time">Posté {{Carbon\Carbon::parse($tool->created_at)->diffForHumans()}}</em></h2>

                    </div>
                    <div class="d-flex justify-content-around">

                        <small>Pays de la Loire</small>
                        <small>{{ $tool->price}} €</small>

                    </div>
                    <hr>

                    <p class="card-text">{{$tool->description}}</p>


                    <div><a href="/projets/{{ $tool->id }}" class="btn btn-primary">Voir l'outil</a> </div>

        @endforeach

                </div>
            </div>
        <li>
    </ul>
@endsection
</div>
