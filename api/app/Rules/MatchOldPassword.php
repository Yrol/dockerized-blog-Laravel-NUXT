<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements Rule
{
    /**
     * Create a new rule instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * The logic for the rule will be added here
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //check the given password (passed in $value) with the current password using Hash
        return Hash::check($value, auth()->user()->password);
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'Your current password does not match';
    }
}
