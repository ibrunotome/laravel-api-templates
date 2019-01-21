<?php

namespace App\Http\Controllers;

use App\Contracts\ProfileRepository;
use App\Contracts\UserRepository;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /** @var UserRepository */
    private $userRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->resourceItem = UserResource::class;
    }

    /**
     * Get JSON object of current logged user.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function profile(Request $request)
    {
        $allowedIncludes = [
            'profile',
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        $id = auth()->id();

        if ($request->has('include')) {
            $with = array_intersect($allowedIncludes, explode(',', strtolower($request->get('include'))));

            $cacheKey = 'user:' . implode($with) . $id;

            $user = Cache::tags('users:' . $id)->remember($cacheKey, 60, function () use ($with, $id) {
                return $this->userRepository->with($with)->findOneById($id);
            });

            return $this->respondWithItem($user);
        }

        $user = $this->userRepository->findOneById($id);

        return $this->respondWithItem($user);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->only([
            'name',
            'anti_phishing_code'
        ]);

        $response = $this->profileRepository->update(auth()->user()->profile, $data);

        return (new ProfileResource($response))
            ->additional(['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]);
    }

    /**
     * Update the user password.
     *
     * @param PasswordUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $response = $this->userRepository->update($user, $request->only(['password']));

        return $this->respondWithItem($response);
    }

    /**
     * Set the read_at attribute for all non visualized notifications of user.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function visualizeAllNotifications()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }

    /**
     * Set the read_at attribute to a given notification.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function visualizeNotification($id)
    {
        $user = auth()->user();

        $user->unreadNotifications()->findOrFail($id)->update(['read_at' => now()]);

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }
}