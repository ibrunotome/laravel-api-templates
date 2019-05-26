<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedDevice;
use Illuminate\Http\Response;

class AuthorizeDeviceController extends Controller
{
    public function authorizeDevice(string $token)
    {
        /**
         * @var AuthorizedDevice $authorizedDevice
         */
        $authorizedDevice = AuthorizedDevice::with([])
            ->withoutGlobalScopes()
            ->where('authorization_token', '=', $token)
            ->first();

        if (!empty($authorizedDevice)) {
            if (empty($authorizedDevice->authorized_at)) {
                $authorizedDevice->update(['authorized_at' => now()->format('Y-m-d H:i:s.u')]);
            }

            $message = __('Device/location successfully authorized');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for authorize new device/location');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(string $id)
    {
        $model = AuthorizedDevice::with([])->findOrFail($id);

        try {
            $model->delete();

            return $this->respondWithNoContent();
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => trans('messages.exception'),
            ];
        }
    }
}
