@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Roles par utilisateurs</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($users as $user)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                                        </div>
                                        <div class="col-7">
                                            <form class="input-group mb-3" method="POST" action="{{ route('role.user.update', $user->id) }}">
                                                @csrf
                                                <select id="role" class="form-control @error('category') is-invalid @enderror" name="role" required autocomplete="off" @if(Auth::id() === $user->id) disabled @endif>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" @if($user->role->id === $role->id) selected @endif>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    @method('PUT')
                                                    <button class="btn btn-secondary" @if(Auth::id() === $user->id) disabled @endif>Changer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
