<?php


namespace App\Policies;


use App\Advert;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertPolicy
{
    use HandlesAuthorization;

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(User $user)
    {
        return $user->role != $this->roleRepository->getRoleByName('suspended');
    }

    public function update(User $user, Advert $advert)
    {
        return ($this->create($user) && $user->id === $advert->user_id) || ($user->role == $this->roleRepository->getRoleByName('admin'));
    }

    public function follow(User $user, Advert $advert)
    {
        if ($user->role != $this->roleRepository->getRoleByName('suspended'))
            if ($user->id != $advert->user->id)
                return true;

        return false;
    }

}
