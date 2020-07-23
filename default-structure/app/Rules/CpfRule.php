<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfRule implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        $value = preg_replace('/[^0-9]/', '', (string)$value);

        if (strlen($value) !== 11) {
            return false;
        }

        $index2 = 10;
        $sum = 0;

        for ($index1 = 0; $index1 < 9; $index1++) {
            $sum += (int)$value[$index1] * $index2;
            $index2--;
        }

        $rest = $sum % 11;
        if ((int)$value[9] !== ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        $index2 = 11;
        $sum = 0;

        for ($index1 = 0; $index1 < 10; $index1++) {
            $sum += (int)$value[$index1] * $index2;
            $index2--;
        }

        $rest = $sum % 11;

        return (int)$value[10] === ($rest < 2 ? 0 : 11 - $rest);
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return __('Please fill a valid CPF');
    }
}
