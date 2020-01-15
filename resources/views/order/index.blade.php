@extends('layouts.app')
@section('content')
        <h1 class="text-center">order!</h1>
        <div id="map" style='width: 400px; height: 300px;'></div> 
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

function geoloc(){ // ou tout autre nom de fonction
    var geoSuccess = function(position) { // Ceci s'exécutera si l'utilisateur accepte la géolocalisation
        startPos = position;
        userlat = startPos.coords.latitude;
        userlon = startPos.coords.longitude;
        console.log("lat: "+userlat+" - lon: "+userlon);
    };
    var geoFail = function(){ // Ceci s'exécutera si l'utilisateur refuse la géolocalisation
        console.log("refus");
    };
    // La ligne ci-dessous cherche la position de l'utilisateur et déclenchera la demande d'accord
    navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
}
geoloc();


/////////////////////////////////////////////////////////////////
        mapboxgl.accessToken = "pk.eyJ1IjoicmVtaWxhbiIsImEiOiJjazVlMWRhcm0wMDliM2hwZzNqdGR3MDg5In0.WtI5UN1O2mmbBhNeVyUeTA";
        /* Map: This represents the map on the page. */
        var map = new mapboxgl.Map({
                container: "map",
                style: "mapbox://styles/mapbox/light-v10",
                zoom: 12,
                center: [-0.579901,44.842084]// coordonnées 
        });
        
        map.on("load", function () {
                /* Image: An image is loaded and added to the map. */
                map.loadImage("http://placekitten.com/50/50", function(error, image) { // url de l'image
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
                map.loadImage("http://placekitten.com/40/50", function(error, image) { // url de l'image
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
        });
        



//         {
//         "address": {
//             "city": "Berlin",
//             "city_district": "Mitte",
//             "construction": "Unter den Linden",
//             "continent": "European Union",
//             "country": "Deutschland",
//             "country_code": "de",
//             "house_number": "1",
//             "neighbourhood": "Scheunenviertel",
//             "postcode": "10117",
//             "public_building": "Kommandantenhaus",
//             "state": "Berlin",
//             "suburb": "Mitte"
//         },
//         "boundingbox": [
//             "52.5170783996582",
//             "52.5173187255859",
//             "13.3975105285645",
//             "13.3981599807739"
//         ],
//         "class": "amenity",
//         "display_name": "Kommandantenhaus, 1, Unter den Linden, Scheunenviertel, Mitte, Berlin, 10117, Deutschland, European Union",
//         "importance": 0.73606775332943,
//         "lat": "52.51719785",
//         "licence": "Data \u00a9 OpenStreetMap contributors, ODbL 1.0. https://www.openstreetmap.org/copyright",
//         "lon": "13.3978352028938",
//         "osm_id": "15976890",
//         "osm_type": "way",
//         "place_id": "30848715",
//         "svg": "M 13.397511 -52.517283599999999 L 13.397829400000001 -52.517299800000004 13.398131599999999 -52.517315099999998 13.398159400000001 -52.517112099999999 13.3975388 -52.517080700000001 Z",
//         "type": "public_building"
//     }
        </script>
@endsection
