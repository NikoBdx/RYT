@extends('layouts.app')



@section('title')
    Dashboard | RYT
@endsection



@section('content')

{{-- --------- Menu du Dashboard-------- --}}

<div class="row">
  <div class="col-md-12">
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <a class="navbar-brand" href="dashboard">Tableau De Bord</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="user-register">Gestion des Utilisateurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="post-register">Gestions des Annonces</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
          <h4 class="card-title text-center">Données utilisateurs</h4>
      </div>

      <table class="table">
        <tbody>

          <tr>
            <th>Date de la dernière inscription</th>
            @foreach ( $lastuser as $last)
            <td>{{ date('d/m/Y H:i:s', strtotime($last->created_at)) }}</td>
            @endforeach
          </tr>

          <tr>
            <th><strong>Nombre total d'utilisateurs</strong></th>
            <td class="text-left"><strong>{{ $users->count() }}</strong></td>
          </tr>

          <tr>
            <th>Nombre total d'administrateurs</th>
            <td class="text-left">{{ $users->where('role', 'admin')->count()}}</td>
          </tr>

          <tr>
            <th>Nombre total de clients</th>
            <td>{{ $users->where('role', 'customer')->count()}}</td>
          </tr>

          <tr>
            <th>Nombre total de livreurs</th>
            <td>{{ $users->where('role', 'driver')->count()}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
          <h4 class="card-title text-center">Données annonces</h4>
      </div>

      <table class="table">
        <tbody>

          <tr>
            <th>Date de la dernière annonce</th>
            @foreach ( $lasttool as $last)
            <td>{{ date('d/m/Y H:i:s', strtotime($last->created_at)) }}</td>
            @endforeach
          </tr>

          <tr>
            <th>Nombre total d'annonces</th>
            <td><strong>{{ $tools->count()}}</strong></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>


@endsection

@section('script')

@endsection
