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

    public function getFollowState(User $user, Advert $advert) : bool
    {
        if (is_null($this->getByUserAndModel($user, $advert)))
            return false;
        else
            return true;
    }

    public function getByUserAndModel(User $user, Advert $advert)
    {
        return $user->followPivot()->where('advert_id', $advert->id)->first();
    }
}
