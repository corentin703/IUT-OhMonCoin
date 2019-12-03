
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ $advert->title }}</div>

                    <div class="card-body">
                        {{ $advert->content }}

                        <div class="dropdown-divider"></div>

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
                                Aucune image sur cette annonce
                            </p>
                        @endif
                    </div>
                    @can('advert-update', $advert)
                        <div class="card-footer">
                            <button class="btn btn-secondary" onclick="window.location = '{{ route('advert.edit', $advert->id) }}'">Mettre à jour</button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>


@endsection
