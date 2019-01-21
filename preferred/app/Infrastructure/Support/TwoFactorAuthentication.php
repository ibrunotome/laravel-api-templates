<?php

namespace Preferred\Infrastructure\Support;

use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class TwoFactorAuthentication extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    {
        if (empty($this->getUser()->profile)) {
            return true;
        }

        return
            !$this->getUser()->profile->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * @throws InvalidSecretKey
     */
    protected function getGoogle2FASecretKey()
    {
        $secret = $this->getUser()->profile->{$this->config('otp_secret_column')};

        if (empty($secret)) {
            throw new InvalidSecretKey(__('Secret key cannot be empty'));
        }

        return $secret;
    }
}