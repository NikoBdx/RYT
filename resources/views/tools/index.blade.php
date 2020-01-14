<h1 class="text-center mb-5"> Page de vue des tools</h1>
@extends('layouts.app')
@section('content')

@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
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
    <div class="row d-flex justify-content-center">
    {{ $tools->links() }}
</div>
@endsection
</div>
