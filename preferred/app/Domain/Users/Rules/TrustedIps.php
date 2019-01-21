<?php

namespace Preferred\Domain\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

class TrustedIps implements Rule
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
        $ips = explode(',', $value);

        if (is_array($ips)) {
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
                    return false;
                }
            }

            return true;
        }

        return filter_var($ips, FILTER_VALIDATE_IP) === false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('There is one or more invalid IPs on your trusted IPs list');
    }
}
