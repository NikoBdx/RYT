@extends('layouts.app')
@section('content')

<form action="" method="POST">
        @csrf
        <input type="text" name="q" id="q">
 
         <select class="" id="select" name="category">
             <option value="">Selectionner une categorie</option>
             @foreach ($categories as $category)
                 <option value="{{$category->id}}">{{ $category->name }}</option>
             @endforeach
         </select>
 
        <button type="submit">SUBMIT</button>
     </form>

 
     @endsection