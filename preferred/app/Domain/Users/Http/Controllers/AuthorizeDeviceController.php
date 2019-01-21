<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Http\Response;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Interfaces\Http\Controllers\Controller;

class AuthorizeDeviceController extends Controller
{
    public function verify($token)
    {
        /** @var AuthorizedDevice $authorizedDevice */
        $authorizedDevice = AuthorizedDevice::with([])
            ->where('authorization_token', '=', $token)
            ->whereNull('authorized_at')
            ->first();

        if (!empty($authorizedDevice)) {
            $authorizedDevice->update(['authorized_at' => now()]);
            $message = __('Device/location successfully authorized');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for authorize new device/location');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        $model = AuthorizedDevice::with([])->findOrFail($id);

        try {
            $model->delete();

            return $this->respondWithCustomData(['message' => __('Successfully deleted')], Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => trans('messages.exception')
            ];
        }
    }
}
