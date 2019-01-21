<?php

namespace App\Http\Controllers;

use App\Contracts\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
}