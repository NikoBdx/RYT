@extends('layouts.app')
@section('content')
        <h1 class="text-center">Transfert en cours !</h1>
        {{-- <div id="map-container">
            <div class="d-flex justify-content-center">
                    <div id="map" style='width: 400px; height: 300px;'></div>
                    <div id="instructions"></div>
            </div>
        </div> --}}
        <div class="container d-flex justify-content-center" id="map-container map-canvas">
            <div id="map" style="width:600px;height:400px"></div>  
        </div>
        <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js'></script>
<script>
    mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";   

    const uuid = PubNub.generateUUID();
    const pubnub = new PubNub({
        publishKey: "pub-c-2a42afec-90b5-4e39-b2de-a5c5c01cb5dc",
        subscribeKey: "sub-c-4d4bbee8-3a3a-11ea-afe9-722fee0ed680",
        uuid: uuid
    });

    pubnub.subscribe({
        channels: ['pubnub_onboarding_channel'],
        withPresence: true
    });

    pubnub.addListener({
        message: function(event) {
            // let pElement = document.createElement('p');
            // pElement.appendChild(document.createTextNode(event.message.content));
            // document.body.appendChild(pElement);
        },
        presence: function(event) {
            // let pElement = document.createElement('p');
            // pElement.appendChild(document.createTextNode(event.uuid + " has joined. That's you!"));
            // document.body.appendChild(pElement);
        }
    });

  pubnub.history(
    {
      channel: 'pubnub_onboarding_channel',
      count: 10,
      stringifiedTimeToken: true,
    },
    function (status, response) {
    }
  );

////////// pubnub api//////////
window.lat = {{$userLat}};
window.lng = {{$userLon}};
window.accuracy = "";

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(updatePosition);
    }
    return null;
};

var pnChannel = "pubnub_onboarding_channel";

pubnub.subscribe({channels: [pnChannel]});
pubnub.addListener({ message : redraw });

function updatePosition(position) {
  if (position) {    
    window.lat = position.coords.latitude;
    window.lng = position.coords.longitude;
    window.accuracy = position.coords.accuracy;
  }
}

setInterval(function(){updatePosition(getLocation());}, 10000);
function currentLocation() {
    
  return {lat:window.lat, lng:window.lng, accuracy:window.accuracy};
}

setInterval(function() {
      pubnub.publish({channel:pnChannel, message:currentLocation()});
    }, 5000);

var start = [window.lng,window.lat,window.accuracy]
function circlePoint(time) {
  var radius = 0.01;
  var x = Math.cos(time) * radius;
  var y = Math.sin(time) * radius;
  return {lat:window.lat + y, lng:window.lng + x, accuracy:window.accuracy};
}
var size = "8"
var map;
var mark;

var redraw = function(payload) {
  lat = payload.message.lat;
  lng = payload.message.lng;
  console.log(lat)
  map.setCenter({lat:lat, lng:lng, alt:0});
  mark.setPosition({lat:lat, lng:lng, alt:0});
}

</script>
@endsection
