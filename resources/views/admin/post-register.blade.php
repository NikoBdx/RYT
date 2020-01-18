@extends('layouts.app')


@section('title')
  Enregistrement des annonces | RYT
@endsection


@section('content')

{{-- --------- Menu du Dashboard-------- --}}

<div class="row">
  <div class="col-md-12">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="dashboard">Tableau De Bord</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="user-register">Gestion des Utilisateurs <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="post-register">Gestions des annonces</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gestion annexe</a>
          </li>          
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title text-center"> Gestion des annonces</h4>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                @endif
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary text-center">
                      <th>Titre</th>
                      <th>Description</th>
                      <th>Prix</th>
                      <th>Loueur</th>
                      <th>Photo</th>
                      <th>Editer</th>
                      <th>Supprimer</th>


                    </thead>
                    <tbody>
                        @foreach ($tools as $row)
                      <tr>
                        <td> {{ $row->title }}</td>
                        <td> {{ $row->description }}</td>
                        <td> {{ $row->price }} €/jour</td>
                        <td> {{ $row->user->firstname }} {{ $row->user->lastname }}  </td>
                        <td>
                        <div class="img-square-wrapper">
                                <img class="img-fluid img-thumbnail" width="300" src='{{asset("/storage/{$row->image}")}}'
                                    alt="image-tool">
                        </div>
                        </td>                                           
                        <td>
                            <a href="/post-edit/{{ $row->id }}" class="btn btn-success">Editer</a>
                        <td>
                            <form action="/post-delete/{{ $row->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value=" {{ $row->id }}">
                            <button type="submit" class="btn btn-danger">Supprimer</button>     
                            </form>
                          </td>
                      </tr>
                        @endforeach                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        
</div>
@endsection

@section('script')
@endsection