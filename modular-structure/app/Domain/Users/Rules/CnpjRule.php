<?php

namespace App\Domain\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjRule implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        $value = preg_replace('/[^0-9]/', '', (string)$value);

        if (strlen($value) !== 14) {
            return false;
        }

        if ($value === '00000000000000' || $value === '00.000.000/0000-00') {
            return false;
        }

        $index2 = 5;
        $sum = 0;

        for ($index1 = 0; $index1 < 12; $index1++) {
            $sum += (int)$value[$index1] * $index2;
            $index2 = $index2 === 2 ? 9 : $index2 - 1;
        }

        $resto = $sum % 11;
        if ((int)$value[12] !== ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        $index2 = 6;
        $sum = 0;

        for ($index1 = 0; $index1 < 13; $index1++) {
            $sum += (int)$value[$index1] * $index2;
            $index2 = $index2 === 2 ? 9 : $index2 - 1;
        }

        $resto = $sum % 11;

        return (int)$value[13] === ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return __('Please fill a valid CNPJ');
    }
}
