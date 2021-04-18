<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\Permission;
use App\Domain\Users\Entities\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
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
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.index') . '?include=' . implode(',', $includes))
            ->assertOk()
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
            ->assertStatus(Response::HTTP_BAD_REQUEST)
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
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
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
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @group show
     * @group crud
     */
    public function testShowMe()
    {
        $includes = [
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        LoginHistory::factory()->create(['user_id' => $this->user->id]);
        AuthorizedDevice::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->getJson(route('api.me') . '?include=' . implode(',', $includes))
            ->assertOk()
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
            'loginhistories',
            'authorizeddevices',
            'notifications',
            'unreadnotifications',
        ];

        $user2 = User::factory()->create();
        LoginHistory::factory()->create(['user_id' => $user2->id]);
        AuthorizedDevice::factory()->create(['user_id' => $user2->id]);

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id) . '?include=' . implode(',', $includes))
            ->assertOk()
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
            ->assertStatus(Response::HTTP_NOT_FOUND)
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
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotShowBecauseUnauthorized()
    {
        $user2 = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id))
            ->assertStatus(Response::HTTP_FORBIDDEN);
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

        $user2 = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->patchJson(route('api.users.update', $user2->id), [
                'email' => 'test@test.com',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
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

        $this->user->refresh();

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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The password confirmation does not match');
    }

    /**
     * @group update
     * @group crud
     */
    public function testCannotUpdateAntiPhishingCodeBecauseNotAlphaDash()
    {
        Permission::create(['name' => 'update users']);
        $this->user->givePermissionTo('update users');

        $this
            ->actingAs($this->user)
            ->patchJson(route('api.me.update'), [
                'anti_phishing_code' => 'Test ***',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
