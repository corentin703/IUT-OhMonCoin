<?php


namespace App\Repositories;


use App\Advert;
use Illuminate\Database\Eloquent\Model;

class AdvertRepository extends Repository
{
    public function __construct(Advert $model)
    {
        parent::__construct($model);
    }
}
