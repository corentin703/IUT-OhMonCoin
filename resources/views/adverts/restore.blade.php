@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Restaurer des annonces supprimées</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <ul class="list-group list-group-flush">
                        @if (count($adverts) === 0)
                            Vous n'avez pas supprimé d'annonces.
                        @else
                            @foreach($adverts as $advert)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="@if ($advert->pictures) col-6 @else col-12 @endif">
                                            <a href="{{ route('advert.show', $advert->id) }}" class="stretched-link"><h4>{{ $advert->title }}</h4></a>
                                            <div class="btn-group interactable">
                                                <h5>
                                                    <a class="font-weight-bold" href="{{ route('advert.index.category', $advert->category) }}">Catégorie {{ $advert->category->name }} </a>
                                                    par
                                                    <a class="font-weight-bold" href="{{ route('advert.index.user', $advert->user) }}"> {{ $advert->user->name }}</a>
                                                </h5>
                                            </div>
                                            <p>{{ $advert->content }}</p>
                                            <div class="btn-group interactable" role="group">
                                                <form method="POST" action="{{ route('advert.restore', $advert->id) }}">
                                                    @csrf
                                                    <button class="btn btn-danger">Restorer</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            @if ($advert->pictures()->withTrashed()->get()->count())
                                            <div id="carousel-{{ $advert->id }}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($advert->pictures()->withTrashed()->get() as $key => $picture)
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
                                                     Vous n'aviez pas mis d'image
                                                 </p>
                                            @endif
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

