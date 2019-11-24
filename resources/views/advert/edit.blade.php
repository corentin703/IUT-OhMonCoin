@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form method="POST" action="/advert/{{ $advert->id }}">
                @csrf
                <div class="card">
                    <div class="card-header">Édition d'annonce</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Titre : <input class="form-control" name="title" value="{{ $advert->title }}"/>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                Catégorie : <input class="form-control" name="category" value="{{ $advert->category->name }}"/>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                Contenu : <textarea class="form-control" name="content">{{ $advert->content }}</textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        @method("PATCH")
                        <div class="btn-group" role="group" style="z-index: 1">
                            <button class="btn btn-secondary" type="submit">Mettre à jour</button>
                            <button type="button" class="btn btn-danger" onclick="$('#deleteConfirm').modal();">Supprimer</button>
                        </div>
                    </div>
                </div>
            </form>

            <br/>
            <br/>

            <div class="card">
                <div class="card-header">Édition d'annonce</div>
                <div class="card-body">
                    <div class="card-text">
                        Images :

                        @php $i = 0 @endphp
                        @foreach($pictures as $key => $picture)
                            @if ($i % 5 == 0)
                                <div class="row" style="margin-top: 2%">
                            @endif
                                    <div class="col-2 text-center">
                                        <img class="col" src="{{ asset('public/' . $picture->link) }}"/>
                                        <button class="btn btn-danger" onclick="pictureDelete({{ $picture->id }}, '{{ csrf_token() }}')">Supprimer</button>
                                    </div>
                            @if (++$i % 5 == 0 || $key === count($pictures) - 1)
                                </div>
                            @endif
                        @endforeach

                        <form method="POST" action="{{ route('picture.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="advert_id" value="{{ $advert->id }}"/>
                            <input id="pictures" type="file" class="form-control @error('pictures') is-invalid @enderror" name="pictures[]" title="Ajouter une ou plusieurs image(s)" autocomplete="off" required multiple style="margin-top: 2%">
                            <button type="submit" class="btn btn-primary" style="margin-top: 2%">Soumettre</button>

                            @error('pictures')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </form>
                    </div>
                </div>
{{--                <div class="card-footer">--}}

{{--                </div>--}}
            </div>

        </div>
    </div>

    @include('advert.deleteConfirm')

@endsection

@section('javascript')
        <script src="{{ asset('js/Advert/picture.js') }}"></script>
@endsection
