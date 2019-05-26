<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Http\Requests\ProfileUpdateRequest;
use Preferred\Domain\Users\Http\Resources\ProfileCollection;
use Preferred\Domain\Users\Http\Resources\ProfileResource;
use Preferred\Interfaces\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->resourceItem = ProfileResource::class;
        $this->resourceCollection = ProfileCollection::class;
        $this->authorizeResource(Profile::class);
    }

    /**
     * List all profiles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cacheTag = 'profiles';
        $cacheKey = 'profiles:' . auth()->id() . json_encode(request()->all());

        $collection = Cache::tags($cacheTag)->remember($cacheKey, 3600, function () {
            return $this->profileRepository->findByFilters();
        });

        return $this->respondWithCollection($collection);
    }

    /**
     * Show a profile of current logged user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        /**
         * @var Profile $profile
         */
        $profile = auth()->user()->profile;
        return $this->show($profile);
    }

    /**
     * Show a profile.
     *
     * @param Profile $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Profile $profile)
    {
        return $this->respondWithItem($profile);
    }

    /**
     * Update the profile of current logged user.
     *
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(ProfileUpdateRequest $request)
    {
        /**
         * @var Profile $profile
         */
        $profile = auth()->user()->profile;

        return $this->update($request, $profile);
    }

    /**
     * Update a profile.
     *
     * @param ProfileUpdateRequest $request
     * @param Profile              $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $data = $request->only([
            'name',
            'anti_phishing_code',
        ]);

        $profile = $this->profileRepository->update($profile, $data);

        return $this->respondWithItem($profile);
    }
}
