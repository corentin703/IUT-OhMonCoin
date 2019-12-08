@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Fiche utilisateur</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Nom : {{ $user->name }}
                            </li>
                            <li class="list-group-item">
                                Email : {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                Adresse : {{ $user->address }}
                            </li>
                            <li class="list-group-item">
                                Téléphone : {{ $user->phone }}
                            </li>
                            <li class="list-group-item">
                                Role : {{ $user->role->name }}
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
