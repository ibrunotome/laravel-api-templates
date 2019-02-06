<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedDevice;
use Illuminate\Http\Response;

class AuthorizeDeviceController extends Controller
{
    /**
     * Authorize the device.
     *
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorize($token)
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

    /**
     * Destroy the device.
     *
     * @param $id
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = AuthorizedDevice::with([])
            ->where('user_id', '=', auth()->id())
            ->findOrFail($id);

        try {
            $model->delete();

            return $this->respondWithNoContent();
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => trans('messages.exception')
            ];
        }
    }
}
