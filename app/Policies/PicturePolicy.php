<?php


namespace App\Policies;


use App\Advert;
use App\Picture;
use App\Repositories\RoleRepository;
use App\User;

class PicturePolicy
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(User $user, Advert $advert)
    {
        if ($user->role != $this->roleRepository->getRoleByName('suspended'))
        {
            if ($advert->user->id == $user->id || $user->role == $this->roleRepository->getRoleByName('admin'))
            {
                return true;
            }
        }

        return false;
    }

    public function update(User $user, Picture $picture)
    {
        return $this->create($user, $picture->advert);
    }
}
