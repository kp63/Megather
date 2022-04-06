<?php

namespace App\Enums;

enum Providers: string
{
    case Google = 'google';
    case Discord = 'discord';

    public function isEnabled(): bool
    {
        return config('services.' . $this->value) !== null;
    }
}
