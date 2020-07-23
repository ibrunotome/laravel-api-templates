<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\WeakPasswordRule;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                new WeakPasswordRule(),
            ],
        ];
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param Request $request
     * @param string  $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return $this->respondWithCustomData(['message' => __($response)], Response::HTTP_OK);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->respondWithCustomData(['message' => __($response)], Response::HTTP_BAD_REQUEST);
    }
}
