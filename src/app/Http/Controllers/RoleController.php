<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    private $roleRepository;
    private $userRepository;

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('roles.index', [
            'users' => $this->userRepository->all(),
            'roles' => $this->roleRepository->all(),
        ]);
    }

    public function changeRole(Request $request, User $user)
    {
        $this->authorize('changeRole', Role::class);

        $role = $this->roleRepository->find($request->input('role'));

        $this->roleRepository->changeUserRole($user, $role);

        return Redirect::back();
    }
}
