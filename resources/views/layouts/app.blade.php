<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title class="font-weight-bold>">{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('dist/js/datepicker.min.js') }}"></script>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link href="{{ URL::asset('dist/css/datepicker.min.css')}}" rel="stylesheet" type="text/css">

    
    {{-- Mapbox --}}
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />

    <!-- Extra-js -->
    <script src="{{ URL::asset('dist/js/i18n/datepicker.fr.js')}}"></script>
    @yield('extra-js')


</head>
<body>
    <header>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light head_log shadow-sm">
                <div class="container">
                    <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <div >
                            <?php
                                //  SEARCHBAR
                                //  Get categories to display in th search bar
                                Use App\Model\Category;
                                $categories = Category::All();
                            ?>

                            <form action="{{ action('ToolController@search') }}" method="POST" class="input-group md-form form-sm form-1 pl-0">
                                @csrf
                                {{-- Searchbar Input --}}

                                    <input type="text" class="form-control my-0 py-1" name="q" id="q" placeholder="Rechercher un outils" size="50" autocomplete="off">
                                    <select class="custom-select" id="select" name="category">
                                        <option value="">Selectionner une categorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search text-white" aria-hidden="true"></i></button>
                            </form>
                            <div id="ajax">

                            </div>
                        </div>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                                @if (Route::has('register'))
                                {{-- Lien vers l'enregistrement --}}
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" href="{{ route('register_choice.index')}}">{{ __('S\'inscrire') }}</a>
                                    </li>
                                @endif
                            @else
                        {{-- --------- Notifications de messages pour le loueur-------- --}}
                                @unless (auth()->user()->unreadNotifications->isEmpty())
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ auth()->user()->unreadNotifications->count() }} notification(s) <span class="caret"></span>
                                        </a>
                                        {{-- Toggle de l'utilisateur --}}
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                        <a href="{{ route('tools.showFromNotification',['tool' => $notification->data['toolId'], 'notification' => $notification->id]) }}" class="dropdown-item">{{ $notification->data['lastname'] }}, a posté un message sur <strong>{{ $notification->data['toolTitle'] }}</strong></a>
                                            @endforeach
                                        </div>
                                    </li>
                                @endunless
                                <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Bienvenue,
                                            {{ Auth::user()->firstname }} !<span class="caret"></span>
                                        </a>
                                        {{-- Toggle de l'utilisateur --}}
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="#">{{ __('Mon profil') }}</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Déconnexion') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                            @endguest
                        </ul>


                        @auth
                        @if (Auth::user()->role=='admin')
                            <div>
                                <a href="/dashboard" type="submit" class="btn btn-warning">Tableau de Bord</a>
                            </div>
                        @endif
                        @endauth

                    </div>
                </div>
            </nav>
            <div class="container-fluid leader">
                <div class="container">
                    {{-- Barre de navigation --}}
                    <nav class="navbar navbar-expand-lg navbar-light stroke">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                <a class="nav-link" href="{{ url('/')}}"><i class="fa fa-home"></i> Accueil</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="infos"><i class="fa fa-book"></i> RYT, c'est quoi ?</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tools.index')}}"><i class="fa fa-wrench"></i> Recherche un outil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ asset('file/modele-contrat-location-entre-particuliers.doc') }}"><i class="fa fa-file"></i> Contrat de Location</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('tools.create')}}"><i class="fa fa-plus-circle"></i> Publier une annonce</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('formulaire.index')}}"><i class="far fa-envelope"></i> Contact</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="container">
                {{-- Contenu des views --}}
                <main class="py-4">
{{-- --------- Notifications -------- --}}
                {{-- --------- Success -------- --}}
                 @if (session()->has('success'))
                    <div class="flash flash-success alert alert-dismissible fade show" role="alert">
                            <span><strong>Bravo!</strong> 🎉 {{ session()->get('success') }}</span>
                            <a data-dismiss="alert" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </a>
                    </div>
                @endif
                {{-- --------- Danger -------- --}}
                @if (session()->has('danger'))
                    <div class="flash flash-danger alert alert-dismissible fade show" role="alert">
                        <span><strong>Oops!</strong> 😱 {{ session()->get('danger') }}</span>
                        <a data-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                @endif
                {{-- --------- Warning -------- --}}
                @if (session()->has('warning'))
                    <div class="flash flash-warning alert alert-dismissible fade show" role="alert">
                        <span><strong>Mmh</strong> 🤔 {{ session()->get('xarning') }}>profile picture</a> yet.</span>
                        <a data-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                 @endif
                    @yield('content')
                </main>
                {{-- Footer --}}
                @extends('layouts.footer')
            </div>
        </div>
    </header>
<script>
    $(document).ready(function () {
        $(".flash").fadeOut(3000);
	});
    $(document).click(function(){
        $('#ajax').html(' ');
        $('#ajax').css('border-radius', '0px');
        $('#ajax').css('border', 'none');
    });
    console.log($('#q'))
    $('#q').keyup(function(){

        console.log('SALAM');

        let $data = $(this).serialize();

        console.log($data);

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            type : 'GET',
            url  : "{{URL::to('tools/search')}}",
            data : $data,


            success: function(code) {

            console.log('succes 1');
            $('#ajax').css('border-radius', '5px');
            $('#ajax').css('border', 'whitesmoke 5px solid');
            $('#ajax').html(code);
            console.log('succes 2');

        },

        error: function (erreur) {
            console.log('ERROR :' + erreur.responseText);;
        },
        })
    });
</script>

</body>
</html>

