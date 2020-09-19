<?php

namespace App\Rules\social;

use Illuminate\Contracts\Validation\Rule;

class YouTubeChannelId implements Rule
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
        return preg_match('/^[a-zA-Z0-9\-_]+$/', (string) ($value ?? ''));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'YouTube チャンネルIDの形式が不正です。';
    }
}
