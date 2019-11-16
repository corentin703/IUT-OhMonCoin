<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class OldPasswordRule implements Rule
{
    private $currentUserId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $currentUserId)
    {
        $this->currentUserId = $currentUserId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Hash::check($value, User::find($this->currentUserId)['password']))
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le mot de actuel n\'est pas valide.';
    }
}
