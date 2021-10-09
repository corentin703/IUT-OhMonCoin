@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Categories</div>

                    <div class="card-body">
                        @if(!is_null($categories))
                            <ul class="list-group list-group-flush">
                                @foreach($categories as $category)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                                            </div>
                                            <div class="col-2">
                                                @can('update', \App\Category::class)
                                                    <button class="btn btn-secondary" onclick="window.location = '{{ route('categories.edit', $category->id) }}'">Editer</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            Aucune catégorie n'existe sur le site actuellement
                        @endif
                    </div>
                    @can(['create', 'restore'], \App\Category::class)
                        <div class="card-footer">
                            <div class="row">
                                @can('create', \App\Category::class)
                                <div class="col">
                                    <form method="POST" action="{{ route('categories.store') }}">
                                        @csrf
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ajouter une catégorie :</span>
                                            </div>
                                            <input id="category" type="text" class="form-control" placeholder="Une nouvelle catégorie" name="name" min="3" value="" required aria-label="category" aria-describedby="category">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Créer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endcan
                                @can('restore', \App\Category::class)
                                <div class="col">
                                    <button class="btn btn-danger" onclick="window.location = '{{ route('trashed.categories') }}'">Restaurer des catégories supprimées</button>
                                </div>
                                @endcan
                            </div>

                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection
