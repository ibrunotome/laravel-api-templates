<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /** @var User */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * @group index
     * @group crud
     */
    public function testIndex()
    {
        Permission::create(['name' => 'view any users']);
        $this->user->givePermissionTo('view any users');

        $includes = [
            'profile',
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.index') . '?include=' . implode(',', $includes))
            ->assertSuccessful()
            ->assertSeeText('profile')
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @group index
     * @group crud
     */
    public function testCannotIndexBecauseInvalidInclude()
    {
        Permission::create(['name' => 'view any users']);
        $this->user->givePermissionTo('view any users');

        $includes = [
            'invalidinclude',
        ];

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.index') . '?include=' . implode(',', $includes))
            ->assertStatus(400)
            ->assertSeeText('Allowed include(s) are');
    }

    /**
     * @group index
     * @group crud
     * @group unauthenticated
     */
    public function testCannotIndexBecauseUnauthenticated()
    {
        $this
            ->getJson(route('api.users.index'))
            ->assertStatus(401);
    }

    /**
     * @group index
     * @group crud
     * @group unauthorized
     */
    public function testCannotIndexBecauseUnauthorized()
    {
        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.index'))
            ->assertStatus(403);
    }

    /**
     * @group show
     * @group crud
     */
    public function testShowMe()
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
            ->getJson(route('api.me') . '?include=' . implode(',', $includes))
            ->assertSuccessful()
            ->assertSeeText('profile')
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @group show
     * @group crud
     */
    public function testShow()
    {
        Permission::create(['name' => 'view users']);
        $this->user->givePermissionTo('view users');

        $includes = [
            'profile',
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        $user2 = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user2->id]);
        factory(LoginHistory::class)->create(['user_id' => $user2->id]);
        factory(AuthorizedDevice::class)->create(['user_id' => $user2->id]);

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id) . '?include=' . implode(',', $includes))
            ->assertSuccessful()
            ->assertSeeText('profile')
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @group show
     * @group crud
     */
    public function testCannotShowBecauseModelNotFound()
    {
        Permission::create(['name' => 'view users']);
        $this->user->givePermissionTo('view users');

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.show', Uuid::uuid4()->toString()))
            ->assertStatus(404)
            ->assertSeeText('The requested resource was not found');
    }

    /**
     * @group show
     * @group crud
     * @group unauthenticated
     */
    public function testCannotShowBecauseUnauthenticated()
    {
        $this
            ->getJson(route('api.users.show', $this->user->id))
            ->assertStatus(401);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotShowBecauseUnauthorized()
    {
        $user2 = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user2->id]);

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id))
            ->assertStatus(403);
    }

    /**
     * @group update
     * @group crud
     */
    public function testUpdateMe()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.me.update'), [
                'email' => 'test@test.com',
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'email' => 'test@test.com',
            ]);
    }

    /**
     * @group update
     * @group crud
     * @group unauthorized
     */
    public function testCannotUpdateBecauseUnauthorized()
    {
        Permission::create(['name' => 'update users']);

        $user2 = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user2->id]);

        $this
            ->actingAs($this->user)
            ->patchJson(route('api.users.update', $user2->id), [
                'email' => 'test@test.com',
            ])
            ->assertStatus(403);
    }

    /**
     * @group password
     */
    public function testUpdatePassword()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'ksjd2ksdjf',
                'password_confirmation' => 'ksjd2ksdjf',
            ])
            ->assertSuccessful();

        $this->assertTrue(Hash::check('ksjd2ksdjf', $this->user->password));
    }

    /**
     * @group password
     */
    public function testCannotUpdatePasswordBecauseCurrentPasswordIsInvalid()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password'      => 'secret123',
                'password'              => 'secretxxx',
                'password_confirmation' => 'secretxxx',
            ])
            ->assertStatus(422)
            ->assertSee('Your current password is not valid');
    }

    /**
     * @group password
     */
    public function testCannotUpdatePasswordBecausePasswordIsTooShort()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'secret',
                'password_confirmation' => 'secret',
            ])
            ->assertStatus(422)
            ->assertSee('The password must be at least 8 characters');
    }

    /**
     * @group password
     */
    public function testCannotUpdatePasswordBecausePasswordsNotMatch()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password'      => 'secretxxx',
                'password'              => 'secret1',
                'password_confirmation' => 'secret2',
            ])
            ->assertStatus(422)
            ->assertSee('The password confirmation does not match');
    }
}
