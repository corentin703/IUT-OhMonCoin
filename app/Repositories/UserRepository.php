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
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,deleted_at,NULL'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,deleted_at,NULL'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $user = new $this->model();
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->role_id = $this->roleRepository->getRoleByName('classic')->id;
        $user->save();

        return $user;
    }

    public function update(array $data, $element): ?Model
    {
        $validation = Validator::make($data, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['required', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . $user->id],
        ])->validate();

        $user = $this->getModelInstance($element);

        if ($data['password'])
        {
            $password = Validator::make($data, [
                'oldPassword' => [new OldPasswordRule(Auth::id())],
                'password' => ['min:8', 'confirmed'],
            ])->validate();

            $user->password = Hash::make($password['password']);
        }

        return $user->update($validation);
    }
}
