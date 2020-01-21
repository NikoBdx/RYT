@extends('layouts.app')
@section('content')
@auth
<div class="d-flex justify-content-center">
    <h1 class="justify-content-center">Commande en cours</h1>
</div>

<div class="container d-flex justify-content-center" id="map map-canvas">  
    
    <div id="map" style="width:100%;height:400px"></div>  
</div>
<div id="comment"></div>
<div class="row d-flex justify-content-center"><p> Temps restant : <span id="time"></span></p></div>
@endauth
@guest
{{ url()->previous() }}
@endguest
<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.7.min.js"></script>
<script>
    var lat = "";
    var lng = "";
    // On place les coordonnéees du l'émetteur
    var start = [-0.467547,44.935585];

    // Calcul de la distance en kilomètre
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
    var distance = distance({{$userLat}}, {{$userLon}}, 44.935585, -0.467547, 'K');

    // Calculs centre du trajet
    var centerLon = ({{$userLon}}-0.467547) /2;
    var centerLat = ({{$userLat}} + 44.935585) /2;

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
    
    // Connexion à pubnub
    
    // identification à Pubnub
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
    // console.log(pubnub.addListener(e))
    pubnub.addListener({
        message: function(event)  {      
            mlat = event.message.lat;
            mlng = event.message.lng;
            macc = event.message.accuracy

            function distance2(lat1, lon1, lat2, lon2, unit) {
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
            var distanceDriver = distance2(mlat, mlng, {{$userLat}}, {{$userLon}}, 'K');
            console.log(distanceDriver)
            if (distanceDriver > 0.01){
                coco = Math.round(distanceDriver * 60 / 30)
                
                var instruction = document.querySelector('#time');
                instruction.innerText = coco + ' min';
            }

            // On affiche le marqueur si la précision est inférieure à 15 et non vide  
            if (macc < 15 && macc !== ""){
                // var marker = new mapboxgl.Marker();               
                // marker.setLngLat([mlng,mlat]);
                // marker.addTo(map);
                var marker2 = new mapboxgl.Marker();
                function animateMarker(timestamp) {
                    var radius = 20;
                    
                    // Update the data to a new position based on the animation timestamp. The
                    // divisor in the expression `timestamp / 1000` controls the animation speed.
                    marker2.setLngLat([mlng,mlat]);
                    
                    // Ensure it's added to the map. This is safe to call if it's already added.
                    marker2.addTo(map);
                    
                    // Request the next frame of the animation.
                    requestAnimationFrame(animateMarker);
                }
                requestAnimationFrame(animateMarker);
            }
        },
        presence: function(event) {
            // A utiliser pour afficher les responses avec event.(element)
        }
    }); 
    pubnub.history(
        {
            channel: 'pubnub_onboarding_channel',
            count: 10,
            stringifiedTimeToken: true,
        },
        function (status, response) {
            // A utiliser pour afficher les responses avec reponse.(element)
        }
    );

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
                instructions.insertAdjacentHTML('afterend', '<row class="d-flex justify-content-center"><span class="duration">Temps de transport total estimé à : ' + Math.floor(data.duration / 60 * 1.5) + ' min ' + vehicule + '</span></row>');
            }
        };
        // On envoie la requête
        req.send();
    }
    // On affiche la carte au chargement de la page
    map.on('load', function() {
        // On créé la route
        getRoute(start);
        var coords =  [{{$userLon}},{{$userLat}}] //Les coordonnées d'arrivée qu'on utilise dans end
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
</script>
@endsection