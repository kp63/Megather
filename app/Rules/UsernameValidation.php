<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('/^[a-zA-Z0-9\-_.]{3,20}$/', $value ?? '');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ユーザー名には半角英数字と一部の記号(-_.)のみ使用できます。';
    }
}
