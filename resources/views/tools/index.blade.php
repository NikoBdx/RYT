@extends('layouts.master')
@section('content')
@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
    <div class="row">
        <h1 class="text-center">Enregistrement des outils</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">nom de l'outil</label>
                <input type="text" name="title" id="title">
            </div>
            
            <div class="form-group">
            <label>Description</label>
            <input type="text" name="description">
            </div>

            <div class="form-group">
            <label>Prix</label>
            <input type="number" min="0" step="0.01" name="price">
            </div>
            
            <div class="form-group">
            <label>Photo de l'outil</label>
            <input type="file" name="image">
            </div>            
           
            <div class="form-group">
            <button>Envoyer</button>
            </div>

            </form>
        </div>
    </div>
</div>
@endsection

