<?php

namespace App\Policies;

use App\Category;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * Determine whether the user can view any categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the trashed advert.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewTrashed(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->id === $this->roleRepository->getRoleByName('admin')->id;
    }
}
