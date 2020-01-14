@extends('layouts.app')
@section('content')

@if(!empty($successMessage) )
    <p>{{ $successMessage }}</p>
@endif

<div class="container">
    <ul>
    @foreach ($tools as $tool)
      <a href="/tools/{{ $tool->id }}">
        <li>
          <div class="col-12 mt-3">
            <div class="card card-product">
              <div class="card-horizontal">
                <div class="img-square-wrapper">
                  <img class="image-tool py-2" src='{{asset("/storage/{$tool->image}")}}' alt="image-tool">
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h3 class="card-title">{{ $tool->title }}</h3>
                      <small class="text-muted">Publié {{Carbon\Carbon::parse($tool->created_at)->diffForHumans()}} par {{$tool->user->firstname}}</small>
                    </div>
                    <div>
                      <h2 class="card-title">{{ $tool->price }} €</h2>
                    </div>
                  </div>
                  <p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-between">
                <div>
                  @foreach($tool->categories as $category)
                  <span class="categories">{{ $category->name }} </span>
                @endforeach
                </div>
                <div>
                  <i class="fas fa-map-marker-alt"></i>
                  <span class="localisation">{{ $tool->user->town }} ({{$tool->user->cp}})</span>
                </div>


              </div>
            </div>
          </div>
        </li>
      </a>
        @endforeach
    </ul>

    <div class="row d-flex justify-content-center">
      {{ $tools->links() }}
    </div>
@endsection
</div>
