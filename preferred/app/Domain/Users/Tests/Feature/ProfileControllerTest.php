<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
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

    /**
     * @group show
     * @group crud
     */
    public function testShow()
    {
        $includes = [
            'profile',
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        factory(LoginHistory::class)->create(['user_id' => $this->user->id]);
        factory(AuthorizedDevice::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->getJson(route('api.profile') . '?include=' . implode(',', $includes))
            ->assertSuccessful()
            ->assertSeeText('profile')
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    public function testUpdate()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.update'), [
                'name'               => 'test',
                'anti_phishing_code' => 'TEST'
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'name'             => 'test',
                'antiPhishingCode' => 'TE**'
            ]);
    }

    public function testCannotUpdateAntiPhishingCodeBecauseNotAlphaDash()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.update'), [
                'anti_phishing_code' => 'Test ***',
            ])
            ->assertStatus(422);
    }

    public function testUpdatePassword()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'ksjd2ksdjf',
                'password_confirmation' => 'ksjd2ksdjf',
            ])
            ->assertSuccessful();

        $this->assertTrue(Hash::check('ksjd2ksdjf', $this->user->password));
    }

    public function testCannotUpdatePasswordBecauseCurrentPasswordIsInvalid()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.password.update'), [
                'current_password'      => 'secret123',
                'password'              => 'secretxxx',
                'password_confirmation' => 'secretxxx',
            ])
            ->assertStatus(422)
            ->assertSee('Your current password is not valid');
    }

    public function testCannotUpdatePasswordBecausePasswordIsTooShort()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'secret',
                'password_confirmation' => 'secret',
            ])
            ->assertStatus(422)
            ->assertSee('The password must be at least 8 characters');
    }

    public function testCannotUpdatePasswordBecausePasswordsNotMatch()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'secret1',
                'password_confirmation' => 'secret2',
            ])
            ->assertStatus(422)
            ->assertSee('The password confirmation does not match');
    }
}
