@extends('layouts.app')
@section('content')
@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif
<div class="container">
    <div class="text-center">
        <h1>Réservation d'un outil</h1>
    </div>
    <div class="row">
        <div class="col-md-4 col-ms-12">
            <img id="preview" class="img-fluid img-thumbnail" width="300" src="{{$tool->image}}" alt="">
        </div>
        <div class="col-md-8 col-ms-12">
            <table class="table">
                <thead>
                    <tr>
                        <th >Titre</th>
                        <th >Propietaire</th>
                        <th >ID Order</th>
                        <th >Prix/j</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{{$tool->title}}</th>
                        <td>{{$tool->user->lastname}} {{$tool->user->firstname}}</td>
                        <td>{{$order->id}}</td>
                        <td id="toolPrice">{{$tool->price}}</td>
                    </tr>
                </tbody>
            </table>
            <form action="{{ route('payments.store')  }}" method="POST">
                @csrf
                <label for="date">Je desire louer cet outil à partir du</label>
                <input type='text' id='date' name="date" class='datepicker-here' data-language='fr' data-date-format="yyyy-mm-dd" data-timepicker="true" data-time-format='hh:ii' autocomplete="off"/>
                <label for="day">et je desire louer cet outil pour une durée de</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" name="day" id="day" value="1" >
                    <input type="hidden" name="idOrder" value="{{ $order->id }}">
                    <div class="input-group-append">
                        <span class="input-group-text">JOUR</span>
                    </div>
                </div> 
                <h3 id="displayFullPrice">Prix Total = {{$tool->price}} €</h3>
                <button type="submit" class="btn btn-primary">Commander</button>
            </form>
        </div>
    </div>
</div>


{{-- ------------------------------ Script Selection multiple ------------------------------ --}}
<script>
    
    $( document ).ready(function(){
            $('#date').datepicker({ timepicker: true });
            $('#day').change(function(){
                updatePrice();  
            });
        });
  
        function updatePrice() 
        {
            var toolPrice = $("#toolPrice").html();
            var day = $("#day").val();
            var totalPrice = toolPrice * day;

            $("#displayFullPrice").html('Prix Total = ' + totalPrice + ' €');
        }
      </script>

@endsection
