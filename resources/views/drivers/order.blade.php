@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <h1 class="text-center">Votre course !</h1>
    </div>  
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"><p>Départ : </p></div>
        <div class="col-md-3"><p>Arrivée : </p></div>
        <div class="col-md-3"></div>
           
    </div> 
    <div class="row d-flex justify-content-center" id="map-container map-canvas">
        <div id="map" style="width:100%;height:400px"></div>  
    </div>
    <div class="row d-flex justify-content-center" id="comment">
        <button><a href="#">Commande terminée</a></button>
    </div>
<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js'></script>
<script>
    // Map
    var startLat = 44.935585;
    var startLng = -0.467547;
    var endLat = 44.939585;
    var endLng = -0.457547;
    var start = [-0.467547,44.935585]
    var end = [-0.457547,44.939585]
    function distance(lat1, lon1, lat2, lon2, unit) {
        if ((lat1 == lat2) && (lon1 == lon2)) {
            return 0;
        }
        else {
            var radlat1 = Math.PI * lat1/180;
            var radlat2 = Math.PI * lat2/180;
            var theta = lon1-lon2;
            var radtheta = Math.PI * theta/180;
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist);
            dist = dist * 180/Math.PI;
            dist = dist * 60 * 1.1515;
            if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
            return dist;
        }
    }
    var distance = distance(startLat, startLng, endLat, endLng, 'K');

    // Calculs centre du trajet
    var centerLon = (startLng + endLng) /2;
    var centerLat = (startLat + endLat) /2;

    if(distance <= 10){
        var size = 15;
    }else{
        if(distance > 10 && distance <= 15)  {
            var size = 10;
        }else{
            if(distance > 15 && distance <= 30){
                var size = 8;
            }else{
                var size = 6;
            }
        }
    }

    mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";
    map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/light-v10", // Ici le style de carte
        zoom: size,   // La taille du zoom
        center: [centerLon,centerLat]// coordonnées de centrage de la carte. (dans ce cas, on récupère les coordonnées de l'utilisateur)
    });

    // On créé une fonction getRoute() pour créer une requête du chemin à prendre
    function getRoute(end) {
        // Modèle de l'url pour la requête= https://api.mapbox.com/directions/"la version"/mapbox/"type de service"/"coordonnées de départ(longitude,latitude) arrivée(longitude,latitude)"+'?steps=true&geometries=geojson&access_token='+le token
        /* Les types de déplacement:
            driving : voiture, moto,...
            cycling : vélo
        */
        var url = 'https://api.mapbox.com/directions/v5/mapbox/driving/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;

        // On créé XHR request https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
        // permet d'obtenir des données au format XML, JSON, HTML, ou un simple texte à l'aide de requêtes HTTP.
        var req = new XMLHttpRequest();
        // on instance la requête avec la méthode open()
        req.open('GET', url, true);
        req.onload = function() {
            var json = JSON.parse(req.response);
            var data = json.routes[0];
            var route = data.geometry.coordinates;
            var geojson = {
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: route
                }
            };
            // Si la route existe déjà on utilise setData()
            if (map.getSource('route')) {
                map.getSource('route').setData(geojson);
            } else { // Sinon on créé une nouvelle requête
                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'LineString',
                                coordinates: geojson
                            }
                        }
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });
            }
            driverTransport = 'car';
            if(driverTransport === 'car'){
                vehicule = '🚙';
            }else{
                vehicule = '🚴';
            }
            var time = Math.floor(data.duration / 60);
            if(time != 0){
                var instructions = document.querySelector('#comment');          
                instructions.insertAdjacentHTML('afterend', '<row class="d-flex justify-content-center"><span class="duration">Temps de transport estimé à : ' + Math.floor(data.duration / 60 * 1.5) + ' min ' + vehicule + '</span></row>');
            }
        };
        // On envoie la requête
        req.send();
    }
    // On affiche la carte au chargement de la page
    map.on('load', function() {
        // On créé la route
        getRoute(start);
        var coords =  [endLng,endLat] //Les coordonnées d'arrivée qu'on utilise dans end
        var end = {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'Point', // optionnel
                    coordinates: coords
                }
            }]
        };
        if (map.getLayer('end')) {
            map.getSource('end').setData(end);
        } else {           
            map.addLayer({
                id: 'end',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: {
                        type: 'FeatureCollection',
                        features: [{
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'Point',
                                coordinates: coords
                            }
                        }]
                    }
                },
                paint: {
                    'circle-radius': 10,
                    'circle-color': '#f30'
                }
            });
        }
        getRoute(coords);

        // On ajoute un point de départ
        map.addLayer({
            id: 'point',
            type: 'circle',
            source: {
                type: 'geojson',
                data: {
                    type: 'FeatureCollection',
                    features: [{
                        type: 'Feature',
                        properties: {},
                        geometry: {
                            type: 'Point',
                            coordinates: start
                        }
                    }]
                }
            },
            paint: {
                'circle-radius': 10,
                'circle-color': '#3887be'
            }          
        });        
    });
    map.on();   

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
            mlat = event.message.lat;
            mlng = event.message.lng;
            macc = event.message.accuracy
            // On affiche le marqueur si la précision est inférieure à 15 et non vide  
            if (macc < 15 && macc !== ""){
                var marker = new mapboxgl.Marker();               
                marker.remove();
                marker.setLngLat([mlng,mlat]);
                marker.addTo(map);
            }
        },
        presence: function(event) {
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

    window.lat = startLat;
    window.lng = startLng;
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
        map.setCenter({lat:lat, lng:lng, alt:0});
        mark.setPosition({lat:lat, lng:lng, alt:0});
    }

</script>
@endsection