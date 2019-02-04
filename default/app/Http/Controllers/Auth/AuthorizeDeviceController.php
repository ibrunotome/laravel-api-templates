<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthorizedDeviceRepository;
use App\Http\Controllers\Controller;
use App\Models\AuthorizedDevice;
use Illuminate\Http\Response;

class AuthorizeDeviceController extends Controller
{
    /** @var AuthorizedDeviceRepository */
    private $authorizedDeviceRepository;

    public function __construct(AuthorizedDeviceRepository $authorizedDeviceRepository)
    {
        $this->authorizedDeviceRepository = $authorizedDeviceRepository;
    }

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
