@extends('layouts.app')

@section('title')
Edition des utilisateurs | RYT
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class ="text-center">Edition des annonces</h3>
                    <h4>Annonce publiée par {{ $tool->user->firstname }} {{ $tool->user->lastname }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/post-register-update/{{$tool->id }}" method="POST"  enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="title" value="{{ $tool->title }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" value="{{ $tool->description }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Prix</label>
                                <input type="number" name="price" value="{{ $tool->price }}" class="form-control">
                            </div>

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


                            <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                <div class="custom-file">
                                    <input type="file" id="image" name="image" value="{{ asset("/storage/app/public/{$tool->image}") }}"
                                    class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                                    <label class="custom-file-label" for="image"></label>
                                    @if ($errors->has('image'))
                                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                    @endif
                                </div>
                                <br>
                                <div class="form-group mt-3">
                                    <img id="preview" class="img-fluid img-thumbnail" width="300" src="{{$tool->image}}" alt="{{$tool->name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Enregistrer la modification</button>
                                <a href="/post-register" type="submit" class="btn btn-danger">Annuler la modification</a>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    $('.js-select').select2();
});


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
