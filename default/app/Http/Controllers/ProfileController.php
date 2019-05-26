<?php

namespace App\Http\Controllers;

use App\Contracts\ProfileRepository;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Cache;

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
    public function showMe()
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
