@extends('layouts.app')

@section('content')

{{-- --------- On affiche les messages --------- --}}

    <h5>Messages</h5>
{{-- --------- Boucle sur les messages --------- --}}
    @forelse ($tool->comments as $comment)
    {{-- --------- Card d'affichage des messages --------- --}}
        @if ((($comment->user->id) === (Auth::user()->id)) || ((Auth::user()->id)) === $tool->user->id)
            <div class="card mt-2 mr-5">
                <div class="card-body">
                    <p>{{ $comment->content }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted"><em>Envoyé le {{ $comment->created_at->format('d/m/Y') }}</em></small>
                    <span class="badge badge-primary">{{ $comment->user->firstname }}</span>
                    </div>
                </div>
            </div>
    {{-- --------- On boucle sur les réponses au message --------- --}}
            @foreach ($comment->comments as $replyComment)
                <div class="card mt-2 ml-5">
                    <div class="card-body">
                        <p>{{ $replyComment->content }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><em>Envoyé le {{ $replyComment->created_at->format('d/m/Y') }}</em></small>
                        <span class="badge badge-primary">{{ $replyComment->user->firstname }}</span>
                        </div>
                    </div>
                </div>
             @endforeach
        @endif


{{-- --------- Affichage si connecté (@auth)--------- --}}
        @auth
{{-- --------- Affichage unqiuement pour le loueur --------- --}}
        @if ( !empty(Auth::user()) && Auth::user()->id === $tool->user->id)
            <button class="btn btn-info btn-sm mt-2 mb-2" onclick="toggleReplyComment({{ $comment->id}})">Répondre</button>
{{-- --------- Formulaire de réponse (loueur) --------- --}}
            <form action="{{ route('comments.storeReply', $comment) }}" method="POST" class="ml-5 d-none" id="replyComment-{{ $comment->id}}">
                @csrf
                    <div class="form-group">

                        <input type="hidden" name="tool_id" value={{$tool->id}}>
                        <textarea name="replyComment" class="form-control @error('replyComment') is-invalid @enderror" id="replyComment" rows="3"></textarea>
                        @error('replyComment')
                    <div class="invalid-feddback">{{ $errors->first('replyComment') }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Envoyer la réponse</button>
            </form>
            <button class="btn btn-danger btn-sm mt-2 mb-2" onclick="toggleReplyComment({{ $comment->id}})">Effacer</button>
        @endif

        @endauth
{{-- --------- Si aucun message --------- --}}
    @empty
        <div class="alert alert-info">Aucun message à afficher</div>
    @endforelse
{{-- --------- Formulaire d'envoi de message (client) --------- --}}
    {{-- --------- affichage unqiuement pour le client --------- --}}
    @if ( !empty(Auth::user()) && Auth::user()->id != $tool->user->id)
        <form action="{{ route('comments.store', $tool)}}" method="POST" class="mb-2">
            @csrf
            <div class="form-group">
                <label for="content">Votre message</label>
                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="5"></textarea>
                @error ('content')
                    <div class="invalid-feedback">{{ $errors->first('content')}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Envoyer le message</button>
        </form>
    @endif

<nav class="nav nav-tabs">
  <a class="nav-item nav-link active" href="#accueil">Accueil</a>
  <a class="nav-item nav-link" href="#livres">Livres</a>
  <a class="nav-item nav-link" href="#temoignages">Témoignages</a>
</nav>
<div class="tab-content">
    <div class="tab-pane active" id="accueil">Texte d'accueil</div>
    <div class="tab-pane" id="livres">Tous les livres</div>
    <div class="tab-pane" id="temoignages">Tous les témoignages</div>
</div>
<hr>
<p><strong>Onglet actif </strong>: <span id='actif'></span></p>
<p><strong>Onglet précédent </strong>: <span id='precedent'></span></p>

<script>

    $('a')
    .click(function (e) {
    e.preventDefault()
    $(this).tab('show')
    })

</script>
{{-- --------- JS Toogle sur Réponse --------- --}}
<script>
    function toggleReplyComment(id)
    {
        let element = document.getElementById('replyComment-' + id);
        element.classList.toggle('d-none');
    }
</script>
@endsection



































































