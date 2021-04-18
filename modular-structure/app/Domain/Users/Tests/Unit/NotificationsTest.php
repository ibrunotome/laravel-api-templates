<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Entities\User;
use App\Domain\Users\Notifications\AccountDisabledNotification;
use App\Domain\Users\Notifications\AuthorizeDeviceNotification;
use App\Domain\Users\Notifications\PasswordChangedNotification;
use App\Domain\Users\Notifications\ResetPasswordNotification;
use App\Domain\Users\Notifications\SuccessfulLoginFromIpNotification;
use App\Domain\Users\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use App\Domain\Users\Notifications\VerifyEmailNotification;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testVerifyEmailNotification()
    {
        $token = Uuid::uuid4();
        $notification = new VerifyEmailNotification($token);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString('Confirm your registration', $notification->toMail($this->user)->subject);
    }

    public function testTwoFactorAuthenticationWasDisabledNotification()
    {
        $notification = new TwoFactorAuthenticationWasDisabledNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString(
            'Two Factor Authentication Disabled',
            $notification->toMail($this->user)->subject
        );
    }

    public function testSuccessfulLoginFromIpNotification()
    {
        $mock = [
            'user_id'          => $this->user->id,
            'ip'               => 'test',
            'device'           => 'test',
            'platform'         => 'test',
            'platform_version' => 'test',
            'browser'          => 'test',
            'browser_version'  => 'test',
            'city'             => 'test',
            'region_code'      => 'test',
            'region_name'      => 'test',
            'country_code'     => 'test',
            'country_name'     => 'test',
            'continent_code'   => 'test',
            'continent_name'   => 'test',
            'latitude'         => 'test',
            'longitude'        => 'test',
            'zipcode'          => 'test',
        ];

        $notification = new SuccessfulLoginFromIpNotification($mock);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString('Successful Login From New IP', $notification->toMail($this->user)->subject);
    }

    public function testResetPasswordNotification()
    {
        $token = Uuid::uuid4();
        $notification = new ResetPasswordNotification($token);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertEquals($token, $notification->token);
        $this->assertStringContainsString('Reset password', $notification->toMail($this->user)->subject);
    }

    public function testPasswordChangedNotification()
    {
        $notification = new PasswordChangedNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString('Password Changed', $notification->toMail($this->user)->subject);
    }

    public function testAccountDisabledNotification()
    {
        $notification = new AccountDisabledNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString('Account disabled', $notification->toMail($this->user)->subject);
    }

    public function testAuthorizeDeviceNotification()
    {
        $mock = [
            'ip'                  => '0.0.0.0',
            'device'              => 'test',
            'platform'            => 'test',
            'platform_version'    => 'test',
            'browser'             => 'test',
            'browser_version'     => 'test',
            'city'                => 'test',
            'country_name'        => 'test',
            'authorization_token' => Uuid::uuid4(),
            'authorized_at'       => null,
            'user_id'             => $this->user->id,
        ];

        $notification = new AuthorizeDeviceNotification($mock);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertStringContainsString('Authorize New Device', $notification->toMail($this->user)->subject);
    }
}
