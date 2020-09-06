<?php

namespace App\Domain\Users\Events;

use App\Domain\Users\Entities\User;
use Illuminate\Queue\SerializesModels;

class EmailWasVerifiedEvent
{
    use SerializesModels;

    public User $user;

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
