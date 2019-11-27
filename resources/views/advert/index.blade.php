@extends('layouts.app')

@section('content')

    @inject('advertFollow', 'App\Repositories\AdvertFollowRepository')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <ul class="list-group list-group-flush">
                    @foreach($adverts as $advert)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="@if ($advert->pictures) col-6 @else col-12 @endif">
                                    <a href="{{ route('advert.show', $advert->id) }}" class="stretched-link"><h4>{{ $advert->title }}</h4></a>
                                    <div class="btn-group interactable">
                                        <h5>
                                            <a class="font-weight-bold" href="{{ route('advert.indexByCategory', $advert->category) }}">Catégorie {{ $advert->category->name }} </a>
                                            par
                                            <a class="font-weight-bold" href="{{ route('advert.indexByUser', $advert->user) }}"> {{ $advert->user->name }}</a>
                                        </h5>
                                    </div>
                                    <p>{{ $advert->content }}</p>
                                    <div class="btn-group interactable" role="group">
                                    @can('update', $advert)
                                        <button class="btn btn-secondary" onclick="window.location = '{{ route('advert.edit', $advert->id) }}'">Mettre à jour</button>
                                    @elsecan('follow', $advert)
                                        <button class="btn btn-info" onclick="window.location = '{{ route('advert.follow', $advert->id) }}'">
                                            @if ($advertFollow->getFollowState(Auth::user(), $advert)) Suivre @else Ne plus suivre @endif
                                        </button>
                                    @endcan
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if ($advert->pictures->count())
                                    <div id="carousel-{{ $advert->id }}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($advert->pictures as $key => $picture)
                                            <div class="carousel-item @if($key === 0) active @endif">
                                                <img src="{{ asset('public/' . $picture->link) }}" class="d-block w-100" alt="...">
                                            </div>
                                            @endforeach
                                        </div>
                                        @if ($advert->pictures->count() > 1)
                                        <a class="carousel-control-prev" href="#carousel-{{ $advert->id }}" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel-{{ $advert->id }}" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        @endif
                                    </div>
                                    @else
                                         <p class="text-center">
                                             L'utilisateur n'a pas mis d'image
                                         </p>
                                    @endif
                                </div>

                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@if ((isset($canCreate) && $canCreate) || !isset($canCreate))
    @can('create', App\Advert::class)
        @include('advert.add')
    @endcan
@endif

@endsection
