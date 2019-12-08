@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Utilisateurs</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($users as $user)
                                <li class="list-group-item">
                                    <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
