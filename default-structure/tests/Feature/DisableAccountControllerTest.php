<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class DisableAccountControllerTest extends TestCase
{
    public function testDisableAccount()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertOk()
            ->assertSeeText('Your account was successfully disabled');
    }

    public function testDisableAccountWillFailBecauseMethodNotAllowed()
    {
        $user = factory(User::class)->create();

        $this->putJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED)
            ->assertSeeText('Method not allowed');
    }

    public function testTooManyRequests()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertOk();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS)
            ->assertSeeText('Too many Requests');
    }
}
