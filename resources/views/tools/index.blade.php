<h1 class="text-center mb-5"> Page de vue des tools</h1>
@extends('layouts.app')
@section('content')

@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
    <ul>
        @foreach ($tools as $tool)
        <a href="/tools/{{ $tool->id }}">
            <div class="card-product mb-3">
                <img class="image-tool" src='{{asset("/storage/{$tool->image}")}}' alt="image-tool">
                <div>
                    <div class="card-product-infos">
                        <div class="d-flex justify-content-between">
                            <h2>{{ $tool->title }}</h2>
                            <h2>{{ $tool->price }} €</h2>
                        </div>
                        <p>{{$tool->description}}</p>

                    </div>

                        @foreach($tool->categories as $category)
                            <span class="categories ml-1">{{ $category->name }} </span>
                        @endforeach
                </div>
            </div>
        </a>

        @endforeach

                </div>
            </div>
        <li>
    </ul>
    <div class="row d-flex justify-content-center">
    {{ $tools->links() }}
</div>
@endsection
</div>
