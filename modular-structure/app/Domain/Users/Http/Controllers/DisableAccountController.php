<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Services\DisableAccountService;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DisableAccountController extends Controller
{
    public DisableAccountService $disableAccountService;

    public function __construct(DisableAccountService $disableAccountService)
    {
        $this->disableAccountService = $disableAccountService;
    }

    public function disable($token): JsonResponse
    {
        $response = $this->disableAccountService->handle($token);

        if (!empty($response['error'])) {
            $supportUrl = config('app.support_url');

            return $this->respondWithCustomData([
                'message' => __(
                    'We could not disable your account, please try again or enter in contact with the :support_link',
                    [
                        'support_link' => '<a href="' . $supportUrl . '">' . $supportUrl . '</a>',
                    ]
                ),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->respondWithCustomData(
            ['message' => __('Your account was successfully disabled')],
            Response::HTTP_OK
        );
    }
}
