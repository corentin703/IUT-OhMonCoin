<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRoleUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index', [
            'users' => $this->userRepository->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $model = $this->userRepository->create($request->all());

        if ($model)
            return Redirect::to('/');
        else
            abort(500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userRepository->update($request->all(), $user);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->userRepository->forceDelete($user);

        return Redirect::to('/');
    }
}
