<?php


namespace App\Repositories;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Repository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getCategoryByName(string $name)
    {
        $res =  $this->model::where('name', 'LIKE', '%' . $name . '%')->get();

        if (count($res) === 0)
            return null;

        return $res;
    }

    public function getTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }
}
