<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use App\Infrastructure\Support\TwoFactorAuthenticator;
use Illuminate\Http\Response;
use Tests\TestCase;

class TwoFactorAuthenticationControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testGenerate2faSecret()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.generate2faSecret'))
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => 'Secret Key generated. Follow the next steps',
            ]);
    }

    public function testEnable2fa()
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator(request());

        $this->user->google2fa_enable = false;
        $this->user->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->user->save();

        $otp = $twoFactorAuthenticator->getCurrentOtp($this->user->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.enable2fa'), ['one_time_password' => $otp])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message'         => '2FA is enabled successfully',
                'google2faEnable' => true,
            ]);

        $this->actingAs($this->user)
            ->postJson(route('api.enable2fa'), ['one_time_password' => '123456'])
            ->assertStatus(Response::HTTP_LOCKED)
            ->assertJsonFragment([
                'message'         => 'Invalid 2FA verification code. Please try again',
                'google2faEnable' => false,
            ]);
    }

    public function testDisable2fa()
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator(request());

        $this->user->google2fa_enable = true;
        $this->user->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->user->save();

        $oneTimePassword = $twoFactorAuthenticator->getCurrentOtp($this->user->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.disable2fa'), [
                'password'          => '12345678',
                'one_time_password' => $oneTimePassword,
            ])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => 'Invalid password. Please try again',
            ]);

        $this->actingAs($this->user)
            ->postJson(route('api.disable2fa'), [
                'password'          => 'secretxxx',
                'one_time_password' => $oneTimePassword,
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message'         => '2FA is now disabled',
                'google2faEnable' => false,
            ]);
    }

    public function testVerify2fa()
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator(request());

        $this->user->google2fa_enable = true;
        $this->user->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->user->save();

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'))
            ->assertStatus(Response::HTTP_LOCKED)
            ->assertJsonFragment([
                'message' => 'Invalid 2FA verification code. Please try again',
            ]);

        $oneTimePassword = $twoFactorAuthenticator->getCurrentOtp($this->user->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'), ['one_time_password' => $oneTimePassword])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => '2FA successfully verified',
            ]);
    }
}
