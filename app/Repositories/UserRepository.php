<?php


namespace App\Repositories;


use App\Rules\OldPasswordRule;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository extends Repository
{
    private $roleRepository;

    public function __construct(User $model, RoleRepository $roleRepository)
    {
        parent::__construct($model);

        $this->roleRepository = $roleRepository;
    }

    public function create(array $data): ?Model
    {
        DB::beginTransaction();

        $user = new $this->model();
        $user->fill($data);
        $user->password = Hash::make($data['password']);

        if ($this->all()->count() === 0)
            $user->role = $this->roleRepository->getRoleByName('admin');
        else
            $user->role = $this->roleRepository->getRoleByName('classic');

        $user->save();

        DB::commit();

        return $user;
    }

    public function update(array $data, $element): ?Model
    {
        DB::beginTransaction();

        $user = $this->getModelInstance($element);

        if ($data['password'])
            $user->password = Hash::make($data['password']);

        $user->update($data);

        DB::commit();

        return $user;
    }

    public function getUserByName(string $name)
    {
        $res = $this->model::where('name', 'LIKE', '%' . $name . '%')->get();

        if (count($res) === 0)
            return null;

        return $res;
    }
}
