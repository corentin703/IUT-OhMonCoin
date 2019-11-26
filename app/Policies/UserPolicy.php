<?php

namespace App\Policies;

use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
//    public function view(User $user, User $model)
    public function view(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user = null)
    {
        if (Auth::guest())
            return true;

        if ($user->role === $this->roleRepository->getRoleByName('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if ($user->id === $model->id)
            return true;

        if ($user->role === $this->roleRepository->getRoleByName('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the password.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function updatePassword(User $user)
    {
        return Auth::user() === $user;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if ($user->id === $model->id)
            return true;

        if ($user->role === $this->roleRepository->getRoleByName('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
//    public function restore(User $user, User $model)
    public function restore(User $user)
    {
        if ($user->role === $this->roleRepository->getRoleByName('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
//    public function forceDelete(User $user, User $model)
    public function forceDelete(User $user)
    {
        if ($user->role === $this->roleRepository->getRoleByName('admin'))
            return true;

        return false;
    }
}
