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
        <div class="col-md-8">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                <div class="card">
                    <div class="card-header">Espace personnel</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Nom : <input class="form-control" name="name" value="{{ $user->name }}"/>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                Email : <input class="form-control" name="email" value="{{ $user->email }}"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                Adresse postale : <input class="form-control" name="address" value="{{ $user->address }}"/>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                Téléphone : <input class="form-control" name="phone" value="{{ $user->phone }}"/>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                            <li class="list-group-item">
                                <label>Si vous voulez changer de mot de passe:</label>
                                <div class="row">
                                    <div class="col">
                                        Ancien mot de passe : <input class="form-control" name="oldPassword" value="" type="password" autocomplete="new-password"/>
                                    </div>

                                    <div class="col">
                                        Mot de passe : <input class="form-control" name="password" value="" type="password" autocomplete="new-password"/>
                                    </div>

                                    <div class="col">
                                        Confirmation : <input class="form-control" name="password_confirmation" value="" type="password" autocomplete="new-password"/>
                                    </div>
                                </div>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        @method("PATCH")
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br/>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                <div class="card">
                    <div class="card-header">Suppression</div>
                    <div class="card-body">
                        Mot de passe : <input class="form-control" name="password" value="" type="password" autocomplete="new-password"/>
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
