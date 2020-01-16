@extends('layouts.app')
@section('content')
        <h1 class="text-center">Transfert en cours !</h1>
        <div class="d-flex justify-content-center">
                <div id="map" style='width: 400px; height: 300px;'></div> 
        </div>
<script>
/////////////////////////////////// Zone test ///////////////////////////////////
// var address_recever = "{{ $address }}";
//         var address_sender = "Paris";
// function chercher(){   
        
//         if(address_recever != "" && address_sender != ""){   
//                 $.ajax({
//                         url: "https://nominatim.openstreetmap.org/search", // URL de Nominatim
//                         type: 'get', // Requête de type GET
//                         data: "q="+address_recever+"&format=json&addressdetails=1&limit=1&polygon_svg=1" // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)
//                 }).done(function (response) {
//                 if(response != ""){         
//                         userlat = response[0]['lat'];
//                         userlon = response[0]['lon'];
                        

//                         function chercher_sender(){
//                                 if(address_sender != ""){
//                                         $.ajax({
//                                         url: "https://nominatim.openstreetmap.org/search", // URL de Nominatim
//                                         type: 'get', // Requête de type GET
//                                         data: "q="+address_sender+"&format=json&addressdetails=1&limit=1&polygon_svg=2" // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)
//                                         }).done(function (response_sender) {
//                                         if(response_sender != ""){
//                                                 senderlat = response[0]['lat'];
//                                                 senderlon = response[0]['lon'];
//                                                 address_recever = senderlat + ',' + senderlon;
//                                                 console.log(address_recever);
//                                         console.log(senderlon);
//                                                 // Map
//                                                 mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";
//                                                 /* Map: This represents the map on the page. */
//                                                 var map = new mapboxgl.Map({
//                                                         container: "map",
//                                                         style: "mapbox://styles/mapbox/light-v10",
//                                                         zoom: 12,
//                                                         center: [userlon,userlat]// coordonnées 
//                                                 });
//                                                 map.on("load", function () {
//                                 /* Image: An image is loaded and added to the map. */
//                                 map.loadImage("http://placekitten.com/50/50", function(error, image) { // url de l'image
//                                         if (error) throw error;
//                                         map.addImage("custom-marker", image);
//                                         /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
//                                         map.addLayer({
//                                                 id: "markers",
//                                                 type: "symbol",
//                                                 /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
//                                                 source: {
//                                                         type: "geojson",
//                                                         data: {
//                                                                 type: 'FeatureCollection',
//                                                                 features: [
//                                                                 {
//                                                                         type: 'Feature',
//                                                                         properties: {},
//                                                                         geometry: {
//                                                                                 type: "Point",                                                                   
//                                                                                 coordinates: [userlon,userlat]
//                                                                         }
//                                                                 }
//                                                                 ]
//                                                         }
//                                                 },
//                                                 layout: {
//                                                 "icon-image": "custom-marker",
//                                                 }
//                                         });
                                        
//                                 });
//                                 // console.log(senderlat);
//                                 map.loadImage("http://placekitten.com/40/50", function(error, image) { // url de l'image
                                
//                                         if (error) throw error;
//                                         map.addImage("custom-markers", image);
//                                         /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                                        
//                                         console.log(userlat);
//                                         console.log(userlon);
//                                         map.addLayer({
                                                
//                                                 id: "markerss",
//                                                 type: "symbol",
//                                                 /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
//                                                 source: {
//                                                         type: "geojson",
//                                                         data: {
//                                                                 type: 'FeatureCollection',
//                                                                 features: [
//                                                                 {
//                                                                         type: 'Feature',
//                                                                         properties: {},
//                                                                         geometry: {
//                                                                                 type: "Point",
//                                                                                 coordinates: [senderlat,senderlon]
//                                                                         }
//                                                                 }
//                                                                 ]
//                                                         }
//                                                 },
//                                                 layout: {
//                                                 "icon-image": "custom-markers",
//                                                 }
//                                         });
//                                 });
//                         });







//                                         }                
//                                         }).fail(function (error) {
//                                         alert(error);
//                                         });      
//                                 }
//                         }
//                         chercher_sender();





                        

                        
                        
//                 }                
//                 }).fail(function (error) {
//                 alert(error);
//                 });      
//         }
// }
// chercher();
//////////////////////////////////////////////////////////////


    


/////////////////////////////////////////////////////////////////
        mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";
        /* Map: This represents the map on the page. */
        var map = new mapboxgl.Map({
                container: "map",
                style: "mapbox://styles/mapbox/light-v10",
                zoom: 15,
                center: [-0.579901,44.842084]// coordonnées 
        });
        map.on("load", function () {
                /* Image: An image is loaded and added to the map. */
                map.loadImage("https://img.icons8.com/cotton/48/000000/cottage.png", function(error, image) { // url de l'image
                        if (error) throw error;
                        map.addImage("custom-marker", image);
                        /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                        map.addLayer({
                                id: "markers",
                                type: "symbol",
                                /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                                source: {
                                        type: "geojson",
                                        data: {
                                                type: 'FeatureCollection',
                                                features: [
                                                {
                                                        type: 'Feature',
                                                        properties: {},
                                                        geometry: {
                                                        type: "Point",
                                                        coordinates: [-0.579901,44.842084]
                                                        }
                                                }
                                                        ]
                                        }
                                },
                                layout: {
                                "icon-image": "custom-marker",
                                }
                        });
                });
                map.loadImage("https://img.icons8.com/doodle/48/000000/toolbox.png", function(error, image) { // url de l'image
                        if (error) throw error;
                        map.addImage("custom-markers", image);
                        /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                        map.addLayer({
                                id: "markerss",
                                type: "symbol",
                                /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                                source: {
                                        type: "geojson",
                                        data: {
                                                type: 'FeatureCollection',
                                                features: [
                                                {
                                                        type: 'Feature',
                                                        properties: {},
                                                        geometry: {
                                                        type: "Point",
                                                        coordinates: [-0.578501,44.842084]
                                                        }
                                                }
                                                        ]
                                        }
                                },
                                layout: {
                                "icon-image": "custom-markers",
                                }
                        });
                        
                });
                map.loadImage("https://img.icons8.com/dusk/64/000000/hammer.png", function(error, image) { // url de l'image
                        if (error) throw error;
                        function geoloc(){ // ou tout autre nom de fonction
                                var geoSuccess = function(position) { // Ceci s'exécutera si l'utilisateur accepte la géolocalisation
                                        startPos = position;
                                        driverlat = startPos.coords.latitude;
                                        driverlon = startPos.coords.longitude;
                                        console.log("lat: "+driverlat+" - lon: "+driverlon);
                                };
                        map.addImage("custom-markers", image);
                        /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                        map.addLayer({
                                id: "markersss",
                                type: "symbol",
                                /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                                source: {
                                        type: "geojson",
                                        data: {
                                                type: 'FeatureCollection',
                                                features: [
                                                {
                                                        type: 'Feature',
                                                        properties: {},
                                                        geometry: {
                                                        type: "Point",
                                                        coordinates: [-0.578541,44.842044]
                                                        }
                                                }
                                                        ]
                                        }
                                },
                                layout: {
                                "icon-image": "custom-markerss",
                                }
                        });
                                var geoFail = function(){ // Ceci s'exécutera si l'utilisateur refuse la géolocalisation
                                console.log("refus");
                        };
                        // La ligne ci-dessous cherche la position de l'utilisateur et déclenchera la demande d'accord
                        navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
                        }
                        geoloc();
                });
        });
</script>
@endsection
