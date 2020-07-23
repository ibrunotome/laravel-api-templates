<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class WeakPasswordRule implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        $path = realpath(__DIR__ . '/weak_password_list.txt');

        $data = Cache::rememberForever('weak_password_list', function () use ($path) {
            return collect(explode("\n", file_get_contents($path)));
        });

        return !$data->contains($value);
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return __('This password is just too common. Please try another!');
    }
}
