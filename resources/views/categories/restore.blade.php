@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Restaurer des catégories supprimées</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <ul class="list-group list-group-flush">
                        @if (count($categories) === 0)
                            Vous n'avez pas supprimé de catégories.
                        @else
                            @foreach($categories as $category)
                                <li class="list-group-item">
                                    <a href="{{ route('categories.show', $category->id) }}"><h4>{{ $category->name }}</h4></a>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('trashed.categories.restore', $category->id) }}">
                                            @csrf
                                            <button class="btn btn-danger">Restaurer</button>
                                        </form>
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

