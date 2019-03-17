<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Infrastructure\Support\TwoFactorAuthenticator;
use Tests\TestCase;

class TwoFactorAuthenticationControllerTest extends TestCase
{
    /** @var User */
    private $user;

    /** @var Profile */
    private $profile;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->profile = factory(Profile::class)->create(['user_id' => $this->user->id]);
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

        $this->profile->google2fa_enable = 0;
        $this->profile->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->profile->save();

        $otp = $twoFactorAuthenticator->getCurrentOtp($this->profile->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.enable2fa'), ['one_time_password' => $otp])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message'          => '2FA is enabled successfully',
                'google2fa_enable' => 1,
            ]);

        $this->actingAs($this->user)
            ->postJson(route('api.enable2fa'), ['one_time_password' => '123456'])
            ->assertStatus(423)
            ->assertJsonFragment([
                'message'          => 'Invalid 2FA verification code. Please try again',
                'google2fa_enable' => 0,
            ]);
    }

    public function testDisable2fa()
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator(request());

        $this->profile->google2fa_enable = 1;
        $this->profile->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->profile->save();

        $oneTimePassword = $twoFactorAuthenticator->getCurrentOtp($this->profile->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.disable2fa'), [
                'password'          => '12345678',
                'one_time_password' => $oneTimePassword
            ])
            ->assertStatus(400)
            ->assertJsonFragment([
                'message' => 'Invalid password. Please try again',
            ]);

        $this->actingAs($this->user)
            ->postJson(route('api.disable2fa'), [
                'password'          => 'secretxxx',
                'one_time_password' => $oneTimePassword
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message'          => '2FA is now disabled',
                'google2fa_enable' => 0,
            ]);
    }

    public function testVerify2fa()
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator(request());

        $this->profile->google2fa_enable = 1;
        $this->profile->google2fa_secret = $twoFactorAuthenticator->generateSecretKey(32);
        $this->profile->save();

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'))
            ->assertStatus(423)
            ->assertJsonFragment([
                'message' => 'Invalid 2FA verification code. Please try again',
            ]);

        $oneTimePassword = $twoFactorAuthenticator->getCurrentOtp($this->profile->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'), ['one_time_password' => $oneTimePassword])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => '2FA successfully verified',
            ]);
    }
}
