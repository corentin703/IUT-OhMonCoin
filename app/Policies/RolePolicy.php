<?php

namespace App\Policies;

use App\Repositories\RoleRepository;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    private $roleRepository;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function changeRole(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }
}
