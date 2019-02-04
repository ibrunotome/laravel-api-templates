<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Http\Response;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Events\EmailWasVerifiedEvent;
use Preferred\Interfaces\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        try {
            /** @var Profile $profile */
            $profile = app(ProfileRepository::class)->with(['user'])->findOneByCriteria(['email_token_confirmation' => $token]);
        } catch (\Exception $exception) {
            $message = __('Invalid token for email verification');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $profile->user;

        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new EmailWasVerifiedEvent($user));

            $message = __('Email successfully verified');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for email verification');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
