<?php

namespace Tests;

use App\Domain\Users\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait AttachJwtToken
{
    /**
     * @var User
     */
    protected $loginUser;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param null                                       $driver
     *
     * @return $this
     */
    public function actingAs(\Illuminate\Contracts\Auth\Authenticatable $user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }
}