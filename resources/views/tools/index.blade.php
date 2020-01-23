@extends('layouts.app')
@section('content')

@if(!empty($successMessage) )
<p>{{ $successMessage }}</p>
@endif

<div class="container">
    <ul>
        @foreach ($tools as $tool)
        <a href="/tools/{{ $tool->id }}">
              <div class="blog-card">
                <div class="meta">
                    <div class="photo" style="background-image: url({{$tool->image}})"></div>
                    <ul class="details list-unstyled">
                        <li class="author">{{$tool->user->firstname}} {{$tool->user->lastname}}</li>
                        <li class="date">{{Carbon\Carbon::parse($tool->created_at)->diffForHumans()}}</li>
                    </ul>
                </div>
                <div class="description">
                    <div class="d-flex justify-content-between">
                        <h1>{{ $tool->title }}</h1>
                        <h1>{{ $tool->price }}€</h1>
                    </div>

                    <h2>{{ $tool->user->town }} ({{$tool->user->cp}})</h2>
                    <p>{{ \Illuminate\Support\Str::limit($tool->description, 150, $end='...') }}</p>
                     <div class="d-flex categorie-list">
                        @foreach($tool->categories as $category)
                        <span class="categories">{{ $category->name }} </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </a>

        @endforeach
    </ul>

    <div class="row d-flex justify-content-center">
        {{ $tools->links() }}
    </div>
    @endsection
</div>
