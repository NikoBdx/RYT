@extends('layouts.app')
@section('content')
@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif
<div class="container">
    <div class="row">
        <div class="text-center">
            <h1>Enregistrement des outils</h1>
        </div>

    </div>

{{-- ------------------------------ Nom  ------------------------------ --}}
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title-tool">Nom de l'outil </label>
                    <input type="text" id="title-tool" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
{{-- ------------------------------ Prix ------------------------------ --}}
            <div class="row">
                <div class="col-md-3 sm-12">
                    <label for="price-tool">Prix/Jour</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">€/jour</span>
                        </div>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" step="0.01" name="price" id="price-tool" >
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
{{-- ------------------------------ Catégories ------------------------------ --}}
                <div class="col md-9 sm-12">
                    <div class="form-group">
                    <label for="categories-tool">Selectionnez vos catégories</label>
                    <select class="form-control js-select @error('categories') is-invalid @enderror" id="categories-tool" value="{{ json_encode(old('categories')) }}" multiple="multiple" name="categories[]">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories') ?: []) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categories')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
            </div>
{{-- ------------------------------ Description ------------------------------ --}}
            <div class="form-group">
                <label for="description-tool">Décrivez en quelques lignes votre outil :</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description-tool" rows="5"  name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

{{-- ------------------------------ Image ------------------------------ --}}
            <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                <div class="custom-file">
                    <input type="file" id="image" name="image"
                           class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                    <label class="custom-file-label" for="image"></label>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
                <br>
                <div class="form-group mt-3">
                <img id="preview" class="img-fluid img-thumbnail" width="300" src="#" alt="">
                </div>
            </div>    
            
            <div class="form-group">
                <button class="btn btn-primary">Envoyer</button>
            </div>
            </form>
        </div>
    </div>

</div>

{{-- ------------------------------ Script Selection multiple ------------------------------ --}}


<script>
$(document).ready(function() {
    $('.js-select').select2();
});
// script visualisation de l’image avant envoi
$(() => {
    $('input[type="file"]').on('change', (e) => {
        let that = e.currentTarget
        if (that.files && that.files[0]) {
            $(that).next('.custom-file-label').html(that.files[0].name)
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#preview').attr('src', e.target.result)
            }
            reader.readAsDataURL(that.files[0])
        }
    })
})
</script>

@endsection