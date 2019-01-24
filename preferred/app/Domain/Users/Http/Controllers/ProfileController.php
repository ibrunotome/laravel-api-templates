<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Http\Requests\ProfileUpdateRequest;
use Preferred\Domain\Users\Http\Resources\ProfileResource;
use Preferred\Interfaces\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->resourceItem = ProfileResource::class;
        $this->authorizeResource(Profile::class);
    }

    public function index()
    {
        $cacheTag = 'profiles';
        $cacheKey = 'profiles:' . auth()->id() . json_encode(request()->all());

        $collection = Cache::tags($cacheTag)->remember($cacheKey, 60, function () {
            return $this->profileRepository->findByFilters();
        });

        return $this->respondWithCollection($collection);
    }

    public function me()
    {
        /** @var Profile $profile */
        $profile = auth()->user()->profile;
        return $this->show($profile);
    }

    public function show(Profile $profile)
    {
        return $this->respondWithItem($profile);
    }

    public function updateMe(ProfileUpdateRequest $request)
    {
        /** @var Profile $profile */
        $profile = auth()->user()->profile;
        return $this->update($request, $profile);
    }

    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $data = $request->only([
            'name',
            'anti_phishing_code'
        ]);

        $profile = $this->profileRepository->update($profile, $data);

        return $this->respondWithItem($profile);
    }
}
