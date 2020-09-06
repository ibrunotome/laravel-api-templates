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
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->resourceItem = UserResource::class;
        $this->resourceCollection = UserCollection::class;
        $this->authorizeResource(User::class);
    }

    /**
     * List all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
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
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = auth()->user();
        return $this->show($request, $user);
    }

    /**
     * Show an user.
     *
     * @param Request $request
     * @param User    $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, User $user)
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
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(UserUpdateRequest $request)
    {
        $user = auth()->user();
        return $this->update($request, $user);
    }

    /**
     * Update an user.
     *
     * @param UserUpdateRequest $request
     * @param User              $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }

    /**
     * Update password of logged user.
     *
     * @param PasswordUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = auth()->user();
        $data = $request->only(['password']);

        $response = $this->userRepository->update($user, $data);

        return $this->respondWithItem($response);
    }
}
