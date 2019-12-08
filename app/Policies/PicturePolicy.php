<?php

namespace App\Policies;

use App\Advert;
use App\Picture;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PicturePolicy
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
     * Determine whether the user can view any pictures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the picture.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can create pictures.
     *
     * @param  \App\User  $user
     * @param  \App\Advert $advert
     * @return mixed
     */
    public function create(User $user, Advert $advert)
    {
        if ($user->role->id != $this->roleRepository->getRoleByName('suspended')->id)
        {
            if ($advert->user->id === $user->id || $user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the picture.
     *
     * @param  \App\User  $user
     * @param  \App\Picture  $picture
     * @return mixed
     */
    public function update(User $user, Picture $picture)
    {
        return $this->create($user, $picture->advert);
    }

    /**
     * Determine whether the user can delete the picture.
     *
     * @param  \App\User  $user
     * @param  \App\Picture  $picture
     * @return mixed
     */
    public function delete(User $user, Picture $picture)
    {
        if ($user->id === $picture->advert->user->id)
            return true;

        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the picture.
     *
     * @param  \App\User  $user
     * @param  \App\Picture  $picture
     * @return mixed
     */
    public function restore(User $user, Picture $picture)
    {
        if ($user->id === $picture->advert->user_id)
            return true;

        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the picture.
     *
     * @param  \App\User  $user
     * @param  \App\Picture  $picture
     * @return mixed
     */
    public function forceDelete(User $user, Picture $picture)
    {
        if ($user->id === $picture->advert->user->id)
            return true;

        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            return true;

        return false;
    }
}
