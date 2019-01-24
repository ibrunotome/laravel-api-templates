<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Preferred\Domain\Users\Contracts\UserRepository;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Http\Requests\PasswordUpdateRequest;
use Preferred\Domain\Users\Http\Requests\UserUpdateRequest;
use Preferred\Domain\Users\Http\Resources\UserCollection;
use Preferred\Domain\Users\Http\Resources\UserResource;
use Preferred\Interfaces\Http\Controllers\Controller;

class UserController extends Controller
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->resourceItem = UserResource::class;
        $this->resourceCollection = UserCollection::class;
        $this->authorizeResource(User::class);
    }

    public function me(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        return $this->show($request, $user);
    }

    public function show(Request $request, User $user)
    {
        $allowedIncludes = [
            'profile',
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        if ($request->has('include')) {
            $with = array_intersect($allowedIncludes, explode(',', strtolower($request->get('include'))));

            $cacheTag = 'users';
            $cacheKey = implode($with) . $user->id;

            $user = Cache::tags($cacheTag)->remember($cacheKey, 60, function () use ($with, $user) {
                return $this->userRepository->with($with)->findOneById($user->id);
            });

            return $this->respondWithItem($user);
        }

        return $this->respondWithItem($user);
    }

    public function index()
    {
        $cacheTag = 'users';
        $cacheKey = 'users:' . auth()->id() . json_encode(request()->all());

        $collection = Cache::tags($cacheTag)->remember($cacheKey, 60, function () {
            return $this->userRepository->findByFilters();
        });

        return $this->respondWithCollection($collection);
    }

    public function updateMe(UserUpdateRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        return $this->update($request, $user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->only(['email']);
        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }

    /**
     * Update password of logged user.
     *
     * @param PasswordUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $data = $request->only(['password']);

        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }
}
