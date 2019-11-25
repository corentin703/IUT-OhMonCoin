<?php


namespace App\Repositories;


use App\Advert;
use App\AdvertFollow;
use App\User;

class AdvertFollowRepository extends Repository
{
    public function __construct(AdvertFollow $model)
    {
        parent::__construct($model);
    }

    public function getByUserAndModel(User $user, Advert $advert)
    {
        return $user->follow()->where('advert', $advert)->get();
    }
}
