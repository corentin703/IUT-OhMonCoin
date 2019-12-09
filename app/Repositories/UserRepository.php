<?php


namespace App\Repositories;


use App\Rules\OldPasswordRule;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        $user = new $this->model();
        $user->fill($data);
        $user->password = Hash::make($data['password']);
//        $user->role_id = $this->roleRepository->getRoleByName('classic')->id;

        if ($this->all()->count() === 0)
            $user->role = $this->roleRepository->getRoleByName('admin');
        else
            $user->role = $this->roleRepository->getRoleByName('classic');

        $user->save();

        return $user;
    }

    public function update(array $data, $element)
    {
        $user = $this->getModelInstance($element);

        if ($data['password'])
            $user->password = Hash::make($data['password']);

        $user->update($data);

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
