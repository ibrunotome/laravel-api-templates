<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class DisableAccountControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Queue::fake();
        Notification::fake();
    }

    public function testDisableAccount()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);

        $this->postJson(route('api.account.disable', [$profile->email_token_disable_account]))
            ->assertSuccessful()
            ->assertSeeText('Your account was successfully disabled');
    }

    public function testDisableAccountWillFailBecauseMethodNotAllowed()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);

        $this->putJson(route('api.account.disable', [$profile->email_token_disable_account]))
            ->assertStatus(405)
            ->assertSeeText('Method not allowed');
    }

    public function testTooManyRequests()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);

        $this->postJson(route('api.account.disable', [$profile->email_token_disable_account]))
            ->assertSuccessful();

        $this->postJson(route('api.account.disable', [$profile->email_token_disable_account]))
            ->assertStatus(429)
            ->assertSeeText('Too many attemps');
    }
}
