<?php

namespace App\Policies;

use App\Advert;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdvertPolicy
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
     * Determine whether the user can view any adverts
     * (for general and both by User & by Category).
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the advert.
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
        return Auth::check();
    }

    /**
     * Determine whether the user can create adverts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->id != $this->roleRepository->getRoleByName('suspended')->id;
    }

    /**
     * Determine whether the user can update the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function update(User $user, Advert $advert)
    {
        if ($user->role->id != $this->roleRepository->getRoleByName('suspended')->id && $user->id === $advert->user->id)
            return true;

//        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
//            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function delete(User $user, Advert $advert)
    {
        if ($user->id === $advert->user_id)
            return true;

        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function restore(User $user, Advert $advert)
    {
        if ($user->id === $advert->user_id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function forceDelete(User $user, Advert $advert)
    {
        if ($user->role->id === $this->roleRepository->getRoleByName('admin')->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can follow the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function follow(User $user, Advert $advert)
    {
        if ($user->role->id != $this->roleRepository->getRoleByName('suspended')->id)
            if ($user->id != $advert->user->id)
                return true;

        return false;
    }
}
