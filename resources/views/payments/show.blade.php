@extends('layouts.app')
@section('content')
    
    <div class="container border border-dark">

        <table class="table table-responsive table-bordered">
            <thead>
              <tr>
                <th scope="col">{{'Date : ' . date('Y-m-d : H.i.s')}}</th>
                
                <th scope="col"> RYT - Rent Your Tool </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
            </tr>
            <tr>
                <!-- Données Utilisateur demandant une location ------------------------------------------->
                <td> {{ $payment->user->firstname.' '. $payment->user->lastname}}</td>
            </tr> 
            <tr> 
                <td> {{ $payment->user->address}}</td>
            </tr>
            <tr> 
                <td> {{$payment->user->town .' '.$payment->user->cp}}</td>
            </tr> 
            <tr> 
                <td> </td>
            </tr> 
            <tr> 
                <!-- Données l'objet a louer -------------------------------------------------------------->
                <td> {{ $payment->tool->id . ' - ' . $payment->tool->title}}</td>
            </tr>
            <tr>
                <td> {{ $payment->tool->description}}</td>
            </tr>
            <tr> 
                <td> </td>
            </tr>
            <tr> 
                <!-- Données relatives au prix ------------------------------------------------------------>
                <td scope="col"> Prix de Loc.</td>
                <td scope="col"> Nbr. de Jour</td>
                <td scope="col"> Prix Total</td>
            </tr>
            <tr> 
                <td> {{ $payment->tool->price}}</td>
                <td> {{ $payment->price / $payment->tool->price }}</td>
                <td> {{ $payment->price}}</td>
            </tr>
            <tr>
                <!-- Données supplementaires sur la commande --------------------------------------------->
                <td> {{ 'N° de Commande : '. $payment->order->id }} </td>
            </tr>
            </tbody>
          </table>

    </div>
    <form action="{{ route('payments.export')}}" method="GET">
        <input type="hidden" name="id" value="{{$payment->id}}">
        <button type="submit" class="btn btn-primary">Exporter votre bon de commande au format PDF</button>
    </form>
    <div>
        <a href="/profile" class="btn btn-primary">Votre Profil</a>
    </div>

@endsection