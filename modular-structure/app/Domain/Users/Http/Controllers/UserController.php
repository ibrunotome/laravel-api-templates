<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Http\Requests\PasswordUpdateRequest;
use App\Domain\Users\Http\Requests\UserUpdateRequest;
use App\Domain\Users\Http\Resources\UserCollection;
use App\Domain\Users\Http\Resources\UserResource;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->resourceItem = UserResource::class;
        $this->resourceCollection = UserCollection::class;
        $this->authorizeResource(User::class);
    }

    /**
     * List all users.
     */
    public function index(): UserCollection
    {
        $cacheTag = 'users';
        $cacheKey = 'users:' . auth()->id() . json_encode(request()->all());

        return Cache::tags($cacheTag)->remember($cacheKey, now()->addHour(), function () {
            $collection = $this->userRepository->findByFilters();

            return $this->respondWithCollection($collection);
        });
    }

    /**
     * Show a current logged user.
     */
    public function profile(Request $request): UserResource
    {
        $user = $request->user();
        return $this->show($request, $user);
    }

    /**
     * Show an user.
     */
    public function show(Request $request, User $user): UserResource
    {
        $allowedIncludes = [
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        if ($request->has('include')) {
            $with = array_intersect($allowedIncludes, explode(',', strtolower($request->get('include'))));

            $cacheTag = 'users';
            $cacheKey = implode($with) . $user->id;

            $user = Cache::tags($cacheTag)->remember($cacheKey, now()->addHour(), function () use ($with, $user) {
                return $user->load($with);
            });
        }

        return $this->respondWithItem($user);
    }

    /**
     * Update the current logged user.
     */
    public function updateMe(UserUpdateRequest $request): UserResource
    {
        $user = $request->user();
        return $this->update($request, $user);
    }

    /**
     * Update an user.
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $data = $request->validated();
        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }

    /**
     * Update password of logged user.
     */
    public function updatePassword(PasswordUpdateRequest $request): UserResource
    {
        $user = $request->user();
        $data = $request->only(['password']);

        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }
}
