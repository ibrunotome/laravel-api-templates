<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\ProfileRepository;
use App\Events\EmailWasVerifiedEvent;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Response;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        try {
            /**
             * @var Profile $profile
             */
            $profile = app(ProfileRepository::class)->with(['user'])->findOneBy(['email_token_confirmation' => $token]);
        } catch (\Exception $exception) {
            $message = __('Invalid token for email verification');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
        }

        /**
         * @var User $user
         */
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
