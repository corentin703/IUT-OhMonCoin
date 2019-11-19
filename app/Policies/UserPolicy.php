<?php


namespace App\Policies;


use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function update(User $user)
    {
        return ($this->updatePassword($user)) || ($user->role == $this->roleRepository->getRoleByName('admin'));
    }

    public function updatePassword(User $user)
    {
        return Auth::user() === $user;
    }
}
