<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Http\Response;
use Preferred\Domain\Users\Services\DisableAccountService;
use Preferred\Interfaces\Http\Controllers\Controller;

class DisableAccountController extends Controller
{
    /** @var DisableAccountService */
    public $disableAccountService;

    public function __construct(DisableAccountService $disableAccountService)
    {
        $this->disableAccountService = $disableAccountService;
    }

    public function disable($token)
    {
        $response = $this->disableAccountService->handle($token);

        if (!empty($response['error'])) {
            return $this->respondWithCustomData([
                'message' => __(
                    'We could not disable your account, please try again or enter in contact with the :support_link',
                    [
                        'support_link' => '<a href="' . config('app.support_url') . '">' . config('app.support_url') . '</a>'
                    ]
                )
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->respondWithCustomData(
            ['message' => __('Your account was successfully disabled')],
            Response::HTTP_OK
        );
    }
}
