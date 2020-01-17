@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Ma commande</h1>
        <h2>Activer la géocalisation GPS !</h2>
        <button>Activer le trajet</button>
    </div>
    <script>
    var options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

new mapboxgl.GeolocateControl({
positionOptions: {
enableHighAccuracy: true
},
trackUserLocation: true
})

function success(pos) {
  var crd = pos.coords;

  console.log('Votre position actuelle est :');
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude : ${crd.longitude}`);
  console.log(`La précision est de ${crd.accuracy} mètres.`);
}

function error(err) {
  console.warn(`ERREUR (${err.code}): ${err.message}`);
}

navigator.geolocation.getCurrentPosition(success, error, options);
    </script>
@endsection