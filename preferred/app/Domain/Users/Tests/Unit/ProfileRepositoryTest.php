<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class ProfileRepositoryTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Profile
     */
    private $profile;

    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->profile = factory(Profile::class)->create(['user_id' => $this->user->id]);
        $this->profileRepository = $this->app->make(ProfileRepository::class);
    }

    public function testSetNewEmailTokenConfirmation()
    {
        $currentToken = $this->profile->email_token_confirmation;
        $this->profileRepository->setNewEmailTokenConfirmation($this->user->id);
        $profileUpdated = Profile::with([])->find($this->profile->id);
        $this->assertNotEquals($currentToken, $profileUpdated->email_token_confirmation);
    }
}
