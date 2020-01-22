<footer>
    <div class="container">
        {{--  Première partie du footer --}}
        <div class="row pt-3">
            <div class="col-md-6">
                <h3>Aide & Conseils</h3>
                <ul>
                    <li><a href="{{ asset('file/modele-contrat-location-entre-particuliers.pdf') }}">Le contrat de location</a></li>
                    <li><a href="/infos">RYT, c'est quoi?</a></li>
                    <li><a href="{{ route('formulaire.index')}}">Contact</a></li>        
                </ul>
            </div>    
            <div class="col-md-6">
                <h3>Espace utilisateur</h3>
                <ul>
                    {{--  Espace utilisateur --}}
                    @auth
                    <li><a href="/profile">Votre profil</a></li>
                    <li><a href="">Publier une annonce</a></li>  
                    @endauth
                    {{--  Espace invité --}}
                    @guest
                    <li><a href="{{ route('login') }}">S'identifier</a></li>
                    <li><a href="{{ route('tools.index')}}">Rechercher un outil</a></li>
                    @endguest                                   
                </ul>
            </div>
        </div>
        {{-- Deuxième partie du footer --}}
        <div class="divider"></div>
        <div class="row social_network">
            <span>RentYourTool 2020</span>
            <div>
                <a href=""><i class="fab fa-facebook-square"></i></a>
                <a href=""><i class="fab fa-twitter-square"></i></a>
            </div>
        </div>
    </div>
</footer>