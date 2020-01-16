@extends('layouts.app')
{{-- --------- JS Toogle sur Réponse --------- --}}
@section('extra-js')
    <script>
        function toggleReplyComment(id)
        {
            let element = document.getElementById('replyComment-' + id);
            element.classList.toggle('d-none');
        }
    </script>
@endsection
@section('content')
{{-- --------- On affiche les messages --------- --}}

    <h5>Messages</h5>
{{-- --------- Boucle sur les messages --------- --}}
    @forelse ($tool->comments as $comment)
{{-- --------- Card d'affichage des messages --------- --}}
        <div class="card mt-2 mr-5">
            <div class="card-body">
                <p>{{ $comment->content }}</p>
                <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><em>Posté le {{ $comment->created_at->format('d/m/Y') }}</em></small>
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
                    <small class="text-muted"><em>Posté le {{ $replyComment->created_at->format('d/m/Y') }}</em></small>
                    <span class="badge badge-primary">{{ $replyComment->user->firstname }}</span>
                    </div>
                </div>
            </div>
            
        @endforeach
{{-- --------- Affichage si connecté (@auth)--------- --}}
        @auth
        <button class="btn btn-info btn-sm mt-2 mb-2" onclick="toggleReplyComment({{ $comment->id}})">Répondre</button>
{{-- --------- Formulaire de réponse (loueur) --------- --}}
    <form action="{{ route('comments.storeReply', $comment) }}" method="POST" class="ml-5 d-none" id="replyComment-{{ $comment->id}}">
        @csrf
            <div class="form-group">
                <label for="replyComment">Ma réponse</label>
                <textarea name="replyComment" class="form-control @error('replyComment') is-invalid @enderror" id="replyComment" rows="3"></textarea>
                @error('replyComment')
            <div class="invalid-feddback">{{ $errors->first('replyComment') }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mb-3">Envoyer la réponse</button>
        </form>
        @endauth
{{-- --------- Si aucun message --------- --}}
    @empty
        <div class="alert alert-info">Aucun message à afficher</div>   
    @endforelse
{{-- --------- Formulaire d'envoi de message (client) --------- --}}
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
@endsection