@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">

      <img class= "img-fluid mx-auto d-block logo-welcome" src='{{asset("/img/RYT-logo-medium.png")}}' alt="logo">

    </div>
</div>

<div class="text-center mt-3 mb-5"><h1>Les Derniers Outils Proposés</h1></div>
<div class="card-deck mt-3">
  @foreach ( $tools as $tool)

    <div class="card card-home">
			<a href="/tools/{{ $tool->id }}">
				<img class="card-img-top" src='{{asset("/storage/{$tool->image}")}}' alt="{{$tool->title}}">
			</a>

					<div class="card-body">
						<a href="/tools/{{ $tool->id }}">
							<h4 class="card-title text-center">{{$tool->title}}</h4>
							<p class="card-text">{{$tool->description}}</p>
						</a>
					</div>


			<a href="/tools/{{ $tool->id }}">
					<div class="card-footer">
						@foreach($tool->categories as $category)
							<span class="categories">{{ $category->name }} </span>
						@endforeach
					</div>
			</a>
		</div>


  @endforeach
</div>

@endsection
