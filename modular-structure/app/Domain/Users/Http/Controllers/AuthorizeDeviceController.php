<?php

namespace App\Domain\Users\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Domain\Users\Entities\AuthorizedDevice;
use App\Interfaces\Http\Controllers\Controller;

class AuthorizeDeviceController extends Controller
{
    public function authorizeDevice(string $token)
    {
        $authorizedDevice = AuthorizedDevice::query()
            ->withoutGlobalScopes()
            ->where('authorization_token', '=', $token)
            ->first();

        if (!empty($authorizedDevice)) {
            if (empty($authorizedDevice->authorized_at)) {
                $authorizedDevice->update(['authorized_at' => now()]);
            }

            $message = __('Device/location successfully authorized');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_OK);
        }

        $message = __('Invalid token for authorize new device/location');

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(string $id)
    {
        $model = AuthorizedDevice::findOrFail($id);

        try {
            $model->delete();

            return $this->respondWithNoContent();
        } catch (Exception $exception) {
            $message = __('Could not delete the authorized device');

            return $this->respondWithCustomData(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
