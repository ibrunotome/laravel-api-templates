<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\User;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private User $user;

    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->userRepository = $this->app->make(UserRepository::class);
    }

    public function testSetNewEmailTokenConfirmation()
    {
        $currentToken = $this->user->email_token_confirmation;
        $this->userRepository->setNewEmailTokenConfirmation($this->user->id);
        $this->user->refresh();
        $this->assertNotEquals($currentToken, $this->user->email_token_confirmation);
    }
}
