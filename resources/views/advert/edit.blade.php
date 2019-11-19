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
                            <li class="list-group-item">
                                Images : Présentation du truc à réfléchir...
                                @error('address')
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
        </div>
    </div>

    @include('advert.deleteConfirm')

@endsection
