<?php


namespace App\Repositories;

use App\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository extends Repository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getRoleByName(string $name) :? Role
    {
        $id = DB::table('roles')->select('id')->where('name', $name)->first();

        if ($id)
            return $this->model->find($id->id);
        else
            return null;
    }

}
