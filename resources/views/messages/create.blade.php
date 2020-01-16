@extends('layouts.app')

@section('content')
    <div class="container">
    <h1>Discutez avec {{ $renter->firstname }}</h1>
    <form action="{{ route('messages.store') }}" method="post">
        @csrf
        <ul>

            @foreach ($messages as $message)
                <div class="card mt-3">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <small><em>Vous:</em></small>
                            <p>" {{$message->content}} "</p>
                        </blockquote>
                    </div>
                </div>
            @endforeach

        </ul>
        <div class="form-group">

        <input type="hidden" name="renter_id" value="{{ $renter->id }}">
        <input type="hidden" name="tool_id" value="{{ $tool->id }}">

            <label for="content">Message:</label>
            <textarea class="form-control @error('dcontent') is-invalid @enderror" id="content" rows="3"
                name="content">{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

</div>

@endsection
