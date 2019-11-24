<?php


namespace App\Repositories;

use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Repository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getCategoryByName(string $name) : ?Category
    {
        $id = DB::table('categories')->select('id')->where('name', $name)->first();

        if ($id)
            return $this->model->find($id->id);
        else
            return null;
    }
}
