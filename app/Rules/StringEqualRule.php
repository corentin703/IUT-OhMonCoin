<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StringEqualRule implements Rule
{
    private $stringToCompare;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $stringToCompare)
    {
        $this->stringToCompare = $stringToCompare;
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
        if ($value === $this->stringToCompare)
            return true;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Votre saisie n\'est pas identique à celle attendue';
    }
}
