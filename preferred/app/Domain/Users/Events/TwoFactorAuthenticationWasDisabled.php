<?php

namespace Preferred\Domain\Users\Events;

use Illuminate\Queue\SerializesModels;
use Preferred\Domain\Users\Entities\User;

class TwoFactorAuthenticationWasDisabled
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
