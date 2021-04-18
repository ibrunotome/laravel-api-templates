<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Events\EmailWasVerifiedEvent;
use App\Interfaces\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EmailVerificationController extends Controller
{
    public function verify($token): JsonResponse
    {
        try {
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
