<?php

namespace Preferred\Domain\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = preg_replace('/[^0-9]/', '', (string)$value);

        if (strlen($value) != 11) {
            return false;
        }

        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--) {
            $sum += $value[$i] * $j;
        }

        $rest = $sum % 11;
        if ($value[9] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--) {
            $sum += $value[$i] * $j;
        }

        $rest = $sum % 11;

        return $value[10] == ($rest < 2 ? 0 : 11 - $rest);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Please fill a valid CPF');
    }
}
