@extends('layouts.app')
@section('content')
<div class="banner-project-show">
    <h1 class="card-title text-center mb-3">{{$tool->title}}</h1>
</div>
<div class="container">
  <div class="text-center mb-3">
  <img class="img-fluid" src="{{$tool->image}}" class="img-responsive" alt="{{$tool->name}}">
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
                                <th colspan="2">
                                    {{$tool->user->town}} ({{$tool->user->cp}})
                                    <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#exampleModalCenter">
                                        Localiser
                                    </button>
                                </th>
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

<!-- ------------- Modale Localisation ---------------------- -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLongTitle">{{$tool->user->address}} {{$tool->user->town}} ({{$tool->user->cp}})</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id='map' style='width: 400px; height: 300px;'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ------------- Script Localisation ---------------------- -->
<script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoibWlrbDMxMjQiLCJhIjoiY2p5azFtbHQwMDkzZjNlb3J2MHQzcG9pdyJ9.kpmULW-SrFK4XiFFqEmITg';
    var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
    mapboxClient.geocoding.forwardGeocode({
        query: "{{$tool->user->address}} {{$tool->user->town}} {{$tool->user->cp}}",
        autocomplete: false,
        limit: 1
    })
        .send()
        .then(function (response) {
            if (response && response.body && response.body.features && response.body.features.length) {
                var feature = response.body.features[0];

                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: feature.center,
                    zoom: 10
                });
                new mapboxgl.Marker()
                    .setLngLat(feature.center)
                    .addTo(map);
            }
        });

</script>

@endsection
