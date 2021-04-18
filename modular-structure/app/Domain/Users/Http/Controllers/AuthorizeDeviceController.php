<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Interfaces\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorizeDeviceController extends Controller
{
    public function authorizeDevice(string $token): JsonResponse
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

    public function destroy(string $id): JsonResponse
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
