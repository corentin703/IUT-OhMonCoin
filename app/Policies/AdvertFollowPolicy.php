<?php

namespace App\Policies;

use App\Advert;
use App\AdvertFollow;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertFollowPolicy
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
     * Determine whether the user can view any advert follows.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the advert follow.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user)
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can create advert follows.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Advert $advert)
    {
        if ($user->role != $this->roleRepository->getRoleByName('suspended'))
            if ($user->id != $advert->user->id)
                return true;

        return false;
    }
}
