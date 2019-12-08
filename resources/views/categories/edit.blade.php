@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('categories.update', $category->id) }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">Paramètre de catégorie</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Nom : <input class="form-control" name="name" value="{{ $category->name }}"/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </li>
                                <li class="list-group-item">
                                    Nombres d'annonces : {{ $category->adverts()->count() }}
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            @method("PUT")
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br/>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">Suppression de catégorie</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Entrez le nom de la catégorie en toute lettres : <input class="form-control" name="name" value=""/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
