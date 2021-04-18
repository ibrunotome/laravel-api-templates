<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class DisableAccountControllerTest extends TestCase
{
    public function testDisableAccount()
    {
        $user = User::factory()->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertOk()
            ->assertSeeText('Your account was successfully disabled');
    }

    public function testDisableAccountWillFailBecauseMethodNotAllowed()
    {
        $user = User::factory()->create();

        $this->putJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED)
            ->assertSeeText('Method not allowed');
    }

    public function testTooManyRequests()
    {
        $user = User::factory()->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertOk();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertOk();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS)
            ->assertSeeText('Too many Requests');
    }
}
