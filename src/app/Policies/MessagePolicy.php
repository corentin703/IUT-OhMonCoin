<?php

namespace App\Policies;

use App\Message;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
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

    /**
     * Determine whether the user can create messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role->id === $this->roleRepository->getRoleByName('suspended')->id)
            return false;

        return true;
    }

}
