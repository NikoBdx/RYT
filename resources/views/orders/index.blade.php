@extends('layouts.app')
@section('content')
        <h1 class="text-center">Transfert en cours !</h1>
        <div id="map-container">
            <div class="d-flex justify-content-center">
                    <div id="map" style='width: 400px; height: 300px;'></div>
                    <div id="instructions"></div>
            </div>
        </div>
        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js'></script>
<script>
    mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";
    /* On créé la carte */

    // Calculs centre du trajet
    var centerLon = ({{$userLon}}-0.467547) /2;
    var centerLat = ({{$userLat}} + 44.935585) /2;

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
            console.log(dist)
            return dist;
        }
    }
    var distance = distance({{$userLat}}, {{$userLon}}, 44.935585, -0.467547, 'K');
   
    // On détermine la taille du zoom   
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

    var map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/light-v10", // Ici le style de carte
        zoom: size,   // La taille du zoom
        center: [centerLon,centerLat]// coordonnées de centrage de la carte. (dans ce cas, on récupère les coordonnées de l'utilisateur)
    });

//     map.addControl(
// new mapboxgl.GeolocateControl({
// positionOptions: {
// enableHighAccuracy: true
// },
// trackUserLocation: true
// })
// );
    // On place les coordonnéees du l'émetteur
    var start = [-0.467547,44.935585];
    
    
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
                var instructions = document.getElementById('map-container');          
                instructions.insertAdjacentHTML('afterend', '<row class="d-flex justify-content-center"><span class="duration">Temps de transport estimé à : ' + Math.floor(data.duration / 60 + 10) + ' min ' + vehicule + '</span></row>');
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
    




        // map.on("load", function () {
        //         /* Image: An image is loaded and added to the map. */
        //         map.loadImage("https://img.icons8.com/cotton/48/000000/cottage.png", function(error, image) { // url de l'image
        //                 if (error) throw error;
        //                 map.addImage("custom-marker", image);
        //                 /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
        //                 map.addLayer({
        //                         id: "userMarker",
        //                         type: "symbol",
        //                         /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
        //                         source: {
        //                                 type: "geojson",
        //                                 data: {
        //                                         type: 'FeatureCollection',
        //                                         features: [
        //                                         {
        //                                                 type: 'Feature',
        //                                                 properties: {},
        //                                                 geometry: {
        //                                                 type: "Point",
        //                                                 coordinates: [{{$userLon}},{{$userLat}}]
        //                                                 }
        //                                         }
        //                                                 ]
        //                                 }
        //                         },
        //                         layout: {
        //                         "icon-image": "custom-marker",
        //                         }
        //                 });
        //         });
        //         map.loadImage("https://img.icons8.com/doodle/48/000000/toolbox.png", function(error, image) { // url de l'image
        //                 if (error) throw error;
        //                 map.addImage("custom-markers", image);
        //                 /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
        //                 map.addLayer({
        //                         id: "senderMarker",
        //                         type: "symbol",
        //                         /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
        //                         source: {
        //                                 type: "geojson",
        //                                 data: {
        //                                         type: 'FeatureCollection',
        //                                         features: [
        //                                         {
        //                                                 type: 'Feature',
        //                                                 properties: {},
        //                                                 geometry: {
        //                                                 type: "Point",
        //                                                 coordinates: [-0.5801422, 44.850922]
        //                                                 }
        //                                         }
        //                                                 ]
        //                                 }
        //                         },
        //                         layout: {
        //                         "icon-image": "custom-markers",
        //                         }
        //                 });
                        
        //         });
        // });
</script>
@endsection
