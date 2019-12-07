<?php

namespace App\Http\Requests;

use App\Rules\OldPasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        $rules = [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['required', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . $user->id],
        ];

        if ($this->input('password'))
        {
            $rules['oldPassword'] = [new OldPasswordRule(Auth::id())];
            $rules['password'] = ['min:8', 'confirmed'];
        }

        return $rules;
    }
}
