@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Création du compte') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                          <div class="col-md-6">
                             <label for="firstname">Prénom</label>
                           <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}"  name="firstname" value="{{ old('firstname') }}">
                                @error('firstname')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                          </div>
                          <div class="col-md-6">
                             <label for="lastname">Nom</label>
                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" >
                            @error('lastname')
                                  <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="form-address">Adresse</label>
                          <input type="search" class="form-control @error('adress') is-invalid @enderror" id="form-address" name="adress" placeholder="Veuillez saisir votre adresse" />
                          @error('adress')
                                  <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="form-address2">Région</label>
                          <input type="text" class="form-control" name="region" id="form-address2"/>
                        </div>
                        <div class="form-group">
                          <label for="form-city">Ville*</label>
                          <input type="text" name="town" class="form-control @error('town') is-invalid @enderror" id="form-city" >
                          @error('town')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="form-zip">Code Postal*</label>
                          <input type="text" class="form-control @error('cp') is-invalid @enderror" name="cp" id="form-zip">
                          @error('cp')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                          @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="password">Mot de Passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                          @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                          </div>
                          <div class="col-md-6">
                            <label for="password-confirm">Confirmer votre mot de passe</label>
                             <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                           @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                          </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enregister') }}
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
(function() {
  var placesAutocomplete = places({
    appId: 'pl5EJ6MHI6L9',
    apiKey: '2f1f3c55274f4e4332f0cfcbf4e42ccd',
    container: document.querySelector('#form-address'),
    templates: {
      value: function(suggestion) {
        return suggestion.name;
      }
    }
  }).configure({
    type: 'address'
  });
  placesAutocomplete.on('change', function resultSelected(e) {
    document.querySelector('#form-address2').value = e.suggestion.administrative || '';
    document.querySelector('#form-city').value = e.suggestion.city || '';
    document.querySelector('#form-zip').value = e.suggestion.postcode || '';
  });
})();
</script>
@endsection
