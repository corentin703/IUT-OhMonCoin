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

                        @if(count($adverts) === 0)
                            @if (isset($searched) && $searched === true && isset($searched) && !$isCurrentUserPage)
                                Aucun résultat pour cette recherche
                            @elseif(isset($searched) && $isCurrentUserPage)
                                Vous n'avez rien posté pour l'instant
                            @else
                                Aucune annonce n'a été postée pour l'instant
                            @endif
                        @else
                            <ul class="list-group list-group-flush">
                            @foreach($adverts as $advert)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="@if ($advert->pictures) col-md-6 @else col-md-12 @endif">
                                            <a href="{{ route('adverts.show', $advert->id) }}" class="stretched-link"><h4>{{ $advert->title }}</h4></a>
                                            <div class="btn-group interactable">
                                                <h5>
                                                    <a class="font-weight-bold" href="{{ route('categories.show', $advert->category->id) }}">Catégorie {{ $advert->category->name }} </a>
                                                    par
                                                    <a class="font-weight-bold" href="{{ route('adverts.index') . '?user=' . $advert->user->id }}"> {{ $advert->user->name }}</a>
                                                </h5>
                                            </div>
                                            <p>{{ $advert->content }}</p>
                                            <div class="btn-group interactable" role="group">
                                            @can('update', $advert)
                                                <button class="btn btn-secondary" onclick="window.location = '{{ route('adverts.edit', $advert->id) }}'">Mettre à jour</button>
                                            @elsecan('follow', $advert)
                                                <button class="btn btn-info" onclick="follow({{ $advert->id }}, '{{ csrf_token() }}')">
                                                    @if ($advertFollow->getFollowState(Auth::user(), $advert)) Ne plus suivre @else Suivre @endif
                                                </button>
                                            @endcan
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if ($advert->pictures->count())
                                            <div id="carousel-{{ $advert->id }}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($advert->pictures as $key => $picture)
                                                    <div class="carousel-item @if($key === 0) active @endif" style="height: 35vh; width: 21vw;">
                                                        <img src="{{ asset('public/' . $picture->link) }}" alt="..." style="display: block; max-height: 35vh; max-width: 21vw;">
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
                                                     Aucune image sur cette annonce
                                                 </p>
                                            @endif
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                    @if (isset($isCurrentUserPage) && $isCurrentUserPage)
                        <div class="card-footer">
                            <button class="btn btn-danger" onclick="window.location = '{{ route('trashed.adverts') }}'">Restaurer des annonces supprimées</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ((isset($isCurrentUserPage) && $isCurrentUserPage) || !isset($isCurrentUserPage))
        @can('create', App\Advert::class)
            @include('adverts.add')
        @endcan
    @endif

@endsection

@section('javascript')
    @parent
    <script src="{{ asset('js/Advert/follow.js') }}"></script>
@endsection
