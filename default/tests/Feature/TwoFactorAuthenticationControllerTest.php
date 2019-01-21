<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Tests\TestCase;

class TwoFactorAuthenticationControllerTest extends TestCase
{
    /** @var User */
    private $user;

    /** @var Profile */
    private $profile;

    public function setUp()
    {
        parent::setUp();

        Queue::fake();
        Notification::fake();

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
        $authenticator = new Authenticator(request());

        $this->profile->google2fa_enable = 0;
        $this->profile->google2fa_secret = $authenticator->generateSecretKey(32);
        $this->profile->save();

        $otp = $authenticator->getCurrentOtp($this->profile->google2fa_secret);

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
        $authenticator = new Authenticator(request());

        $this->profile->google2fa_enable = 1;
        $this->profile->google2fa_secret = $authenticator->generateSecretKey(32);
        $this->profile->save();

        $oneTimePassword = $authenticator->getCurrentOtp($this->profile->google2fa_secret);

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

    /**
     * @group verify2fa
     */
    public function testVerify2fa()
    {
        $authenticator = new Authenticator(request());

        $this->profile->google2fa_enable = 1;
        $this->profile->google2fa_secret = $authenticator->generateSecretKey(32);
        $this->profile->save();

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'))
            ->assertStatus(423)
            ->assertJsonFragment([
                'message' => 'Invalid 2FA verification code. Please try again',
            ]);

        $oneTimePassword = $authenticator->getCurrentOtp($this->profile->google2fa_secret);

        $this->actingAs($this->user)
            ->postJson(route('api.verify2fa'), ['one_time_password' => $oneTimePassword])
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => '2FA successfully verified',
            ]);
    }

//    public function testRefresh2fa()
//    {
//        $authenticator = new Authenticator(request());
//
//        $this->profile->google2fa_enable = 1;
//        $this->profile->google2fa_secret = $authenticator->generateSecretKey(32);
//        $this->profile->save();
//
//        $oneTimePassword = $authenticator->getCurrentOtp($this->profile->google2fa_secret);
//
//        $this->actingAs($this->user)
//            ->patchJson(route('api.profile.anti-phishing-code.update'), [
//                'anti_phishing_code' => 'Test-Code',
//            ])
//            ->assertStatus(423);
//
//        $this->actingAs($this->user)
//            ->patchJson(route('api.profile.anti-phishing-code.update'), [
//                'anti_phishing_code' => 'Test-Code',
//                'one_time_password'  => '123456'
//            ])
//            ->assertStatus(423);
//
//        $this->actingAs($this->user)
//            ->patchJson(route('api.profile.anti-phishing-code.update'), [
//                'anti_phishing_code' => 'Test-Code',
//                'one_time_password'  => $oneTimePassword
//            ])
//            ->assertStatus(200);
//    }
}
