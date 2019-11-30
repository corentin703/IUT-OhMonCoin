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
        if ($this->getByUserAndModel($user, $advert))
            return true;
        else
            return false;
    }

    public function getByUserAndModel(User $user, Advert $advert)
    {
        return $this->getModelInstance($user->follow->where('advert_id', $advert->id))->first();
    }

    public function getAdvertByUser(User $user)
    {
        $advertFollows = $this->getModelInstance($user->follow);

        $adverts = [];
        foreach ($advertFollows as $advertFollow)
        {
            $adverts[] = $advertFollow->advert;
        }

        return $adverts;
    }
}
