@extends('layouts.app')
@section('title')
  Enregistrement des rôles | RYT
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title text-center">Mon profil</h4>
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif
      </div>
      {{-- Card coordonnées user --}}
      <div class="card-body">
        <h5>Mes coordonnées</h5>
        <div class="table-responsive">
          <table class="table">
            <thead class=" text-secondary">
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Adresse</th>
              <th>Code Postal</th>
              <th>Ville</th>
              <th>Rôle</th>
              <th>Nombre d'annonces</th>
              <th>Editer</th>
              @if (Auth::user()->role=='admin')
                <th>Supprimer</th>
              @endif
            </thead>
            <tbody>
              <tr>
                <td> {{ $user->lastname }}</td>
                <td> {{ $user->firstname }}</td>
                <td> {{ $user->email }}</td>
                <td> {{ $user->address }}</td>
                <td> {{ $user->cp }}</td>
                <td> {{ $user->town }}</td>
                <td>
                <?php switch ($user->role) {
                        case 'customer':
                          echo'Client';
                          break;
                        case 'admin':
                          echo"Administrateur";
                          break;
                        case 'driver':
                          echo "Livreur";
                          break;
                        default:
                          echo"aucun";
                            break;
                  } ?>
                  </td>
                  <td class="text-center"> {{ $user->tools->count() }}</td>
                  <td>
                    <a href="/profile-edit/{{ $user->id }}" class="btn btn-success">Editer</a>
                  </td>
                  @if (Auth::user()->role=='admin')
                    <td>
                      <form action="/user-delete/{{ $user->id }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      <input type="hidden" name="id" value=" {{ $user->id }}">
                      <button type="submit" class="btn btn-danger">Supprimer</button>
                      </form>
                    </td>
                  @endif
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{-- Card annonces user --}}
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif
      </div>
      <div class="card-body">
        <h5>Mes annonces publiées</h5>
        <div class="table-responsive">
          <table class="table">
            <thead class="text-secondary">
              <th>Titre</th>
              <th>Description</th>
              <th>Prix</th>
              <th>Photo</th>
              <th>Editer</th>
              <th>Supprimer</th>
            </thead>
            <tbody>
              @foreach ($tools as $tool)
              <tr>
                <td> {{ $tool->title }} </td>
                <td> {{ $tool->description }} </td>
                <td> {{ $tool->price }} €/jour </td>
                <td>
                  <div class="img-square-wrapper">
                    <img class="img-fluid img-thumbnail" width="125" src="{{$tool->image}}" alt="{{$tool->name}}">
                  </div>
                </td>
                <td>
                  <a href="/mypost-edit/{{ $tool->id }}" class="btn btn-success">Editer</a>
                <td>
                  <form action="/mypost-delete/{{ $tool->id }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="id" value=" {{ $tool->id }}">
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
  {{-- Card demandes location utilisateur --}}
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif
      </div>
      <div class="card-body">
        <h5>Mes demandes de location</h5>
        <div class="table-responsive">
          <table class="table">
            <thead class="text-secondary">
              <th>N° de Commande</th>
              <th>Titre</th>
              <th>Prix total</th>
              <th>Durée</th>
              <th>Date de début de location</th>
              <th>Date de fin de location</th>
              <th>Statut de la location</th>
              <th>Voir le tranfert</th>
            </thead>
            <tbody>
              @foreach ($orders as $order)
                <tr>
                  <td> {{ $order->id }}</td>
                  <td> {{ $order->tool->title }}</td>
                  <td> {{ $order->total_price }} €</td>
                  <td> {{ $order->duration }} jours</td>
                  <td> {{ date('d/m/Y', strtotime($order->start_date)) }}</td>
                  <td> {{ date('d/m/Y', strtotime($order->end_date)) }}</td>
                  <td>
                    <?php
                      switch ($order->status) {
                        case 'start':
                          echo 'Acceptée';
                          break;
                        case 'pending':
                          echo "Livraison en cours";
                          break;
                        case 'done':
                          echo "Location en cours";
                          break;
                        default:
                          echo "aucun";
                          break;
                      }
                    ?>
                  </td>
                  <td>
                    <form action="/order/{{ $order->renter_id }}" method="POST">
                      @csrf
                      <?php
                        switch ($order->status) {
                          case 'start':
                            echo '<p>Uniquement lors de la livraison</p>';
                            break;
                          case 'pending':
                            echo '<button type="submit" class="btn btn-secondary w-100">Voir transfert</button>';
                            break;
                          case 'done':
                            echo '<p>Location en cours</p>';
                            break;
                          default:
                            echo "aucun";
                            break;
                          }
                        ?>
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
