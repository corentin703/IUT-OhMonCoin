<?php


namespace App\Policies;


use App\Advert;
use App\Repositories\RoleRepository;
use App\User;

class AdvertPolicy
{
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

}
