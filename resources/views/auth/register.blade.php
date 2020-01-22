@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Création du compte') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf
                      <input name="role" type="hidden" value="customer">
                      <input name="vehicule" type="hidden" value="NULL">

                        <div class="form-group row">
                          <div class="col-md-6">
                             <label for="firstname">Prénom</label>
                           <input required id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}"  name="firstname" value="{{ old('firstname') }}">
                                @error('firstname')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                          </div>
                          <div class="col-md-6">
                             <label for="lastname">Nom</label>
                            <input required id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" >
                            @error('lastname')
                                  <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="form-address">Adresse</label>
                          <input required  type="search"  class="form-control @error('address') is-invalid @enderror" id="form-address" name="address" placeholder="Veuillez saisir votre adresse"/>
                          @error('address')
                                  <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="form-address2">Région</label>
                          <input type="text" class="form-control" name="region" id="form-address2"/>
                        </div>
                        <div class="form-group">
                          <label for="form-city">Ville*</label>
                          <input required type="text" name="town" class="form-control @error('town') is-invalid @enderror" id="form-city" >
                          @error('town')
                            <div  class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="form-zip">Code Postal*</label>
                          <input required type="text" class="form-control @error('cp') is-invalid @enderror" name="cp" id="form-zip">
                          @error('cp')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
{{-- -------- Récupération des coordonnées GPS ------- --}}
                          <input type="hidden" name="latitude" id="form-latitude">
                          <input type="hidden" name="longitude" id="form-longitude">


                        <div class="form-group">
                          <label for="email">Email</label>
                          <input required type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                          @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="password">Mot de Passe</label>
                            <input required id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                          @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                          </div>
                          <div class="col-md-6">
                            <label for="password-confirm">Confirmer votre mot de passe</label>
                            <input required id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                           @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                          </div>
                        </div>


                        <div class="form-group row mt-4 mb-2">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="text-white fas fa-user"></i> {{ __('S\'enregister') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/places.js@1.17.1"></script>
<script>
  
      let input = $("#form-zip");
      input.change( function(){

        let addresse  =  $("#form-address").val();
        let ville     =  $("#form-city").val();
        let cp        =  $("#form-zip").val();

        let data = addresse + ' ' + ville + ' ' + cp;

        if(ville != ""){
            $.ajax({
              
                url: "https://nominatim.openstreetmap.org/search", // URL de Nominatim
                type: 'get', // Requête de type GET
                data: "q="+data+"&format=json&addressdetails=1&limit=1&polygon_svg=1", // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)

                
              }).done(function (response) {
                console.log('reponse is ='+response);
                if(response != ""){
                  userlat = response[0]['lat'];
                  userlon = response[0]['lon'];
                  $("#form-latitude").val(userlat);
                  $("#form-longitude").val(userlon);

                }                
            }).fail(function (error) {
                alert(error);
            });      
        }
     });

  (function () {
    var placesAutocomplete = places({
      appId: 'pl5EJ6MHI6L9',
      apiKey: '2f1f3c55274f4e4332f0cfcbf4e42ccd',
      container: document.querySelector('#form-address'),
      templates: {
        value: function (suggestion) {
          return suggestion.name;
        }
      }
    }).configure({
      type: 'address'
    });
    placesAutocomplete.on('change', function resultSelected(e) {
      let coordonnees = e.suggestion.latlng;
      document.querySelector('#form-address2').value = e.suggestion.administrative || '';
      document.querySelector('#form-city').value = e.suggestion.city || '';
      document.querySelector('#form-zip').value = e.suggestion.postcode || '';
      document.querySelector('#form-latitude').value = coordonnees.lat;
      document.querySelector('#form-longitude').value = coordonnees.lng;

      console.log(coordonnees);

    });
  })();// <--- ON a enlever 2 parenthese ICI
  
</script>
@endsection
