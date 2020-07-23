<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Preferred\Domain\Users\Contracts\UserRepository;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Events\EmailWasVerifiedEvent;
use Preferred\Interfaces\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        try {
            /**
             * @var User $user
             */
            $user = app(UserRepository::class)->findOneBy(['email_token_confirmation' => $token]);
        } catch (Exception $exception) {
            $message = __('Invalid token for email verification');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
        }

        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new EmailWasVerifiedEvent($user));

            $message = __('Email successfully verified');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for email verification');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
