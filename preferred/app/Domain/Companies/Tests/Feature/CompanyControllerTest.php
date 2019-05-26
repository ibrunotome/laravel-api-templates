<?php

namespace Preferred\Domain\Companies\Tests\Feature;

use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Company
     */
    private $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);

        $this->company = factory(Company::class)->create();
    }

    /**
     * @group show
     * @group crud
     */
    public function testIndex()
    {
        Permission::create(['name' => 'view any companies']);
        $this->user->givePermissionTo('view any companies');

        $this->actingAs($this->user)
            ->getJson(route('api.companies.index'))
            ->assertSuccessful()
            ->assertJsonFragment([
                'name'     => $this->company->name,
                'maxUsers' => $this->company->max_users,
            ]);
    }

    /**
     * @group show
     * @group crud
     * @group unauthenticated
     */
    public function testCannotIndexBecauseIsUnauthenticated()
    {
        $this->getJson(route('api.companies.index'))
            ->assertStatus(401);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotIndexBecauseUnauthorized()
    {
        $this->actingAs($this->user)
            ->getJson(route('api.companies.index'))
            ->assertStatus(403);
    }

    /**
     * @group show
     * @group crud
     */
    public function testShow()
    {
        Permission::create(['name' => 'view companies']);
        $this->user->givePermissionTo('view companies');

        $this
            ->actingAs($this->user)
            ->getJson(route('api.companies.show', $this->company->id))
            ->assertSuccessful()
            ->assertJsonFragment([
                'name' => $this->company->name,
            ]);
    }

    /**
     * @group show
     * @group crud
     * @group unauthenticated
     */
    public function testCannotShowBecauseIsUnauthenticated()
    {
        $this
            ->getJson(route('api.companies.show', $this->company->id))
            ->assertStatus(401);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotShowBecauseUnauthorized()
    {
        $this
            ->actingAs($this->user)
            ->getJson(route('api.companies.show', $this->company->id))
            ->assertStatus(403);
    }

    /**
     * @group store
     * @group crud
     */
    public function testStore()
    {
        Permission::create(['name' => 'create companies']);
        $this->user->givePermissionTo('create companies');

        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name'      => 'test',
                'is_active' => 1,
                'max_users' => 20,
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'name'     => 'test',
                'isActive' => true,
                'maxUsers' => 20,
            ]);
    }

    /**
     * @group store
     * @group crud
     */
    public function testCannotStoreBecauseInvalidInput()
    {
        Permission::create(['name' => 'create companies']);
        $this->user->givePermissionTo('create companies');

        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name'      => 'test',
                'max_users' => 3,
            ])
            ->assertStatus(422)
            ->assertSeeText('is_active');

        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name'      => 'test',
                'is_active' => 'test',
                'max_users' => 0,
            ])
            ->assertStatus(422)
            ->assertSeeText('max_users');
    }

    /**
     * @group store
     * @group crud
     * @group unauthenticated
     */
    public function testCannotStoreBecauseIsUnauthenticated()
    {
        $this
            ->postJson(route('api.companies.store'), [
                'name' => 'test',
            ])
            ->assertStatus(401);
    }

    /**
     * @group store
     * @group crud
     * @group unauthorized
     */
    public function testCannotStoreBecauseUnauthorized()
    {
        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name' => 'test',
            ])
            ->assertStatus(403);
    }

    /**
     * @group update
     * @group crud
     */
    public function testUpdate()
    {
        Permission::create(['name' => 'update companies']);
        $this->user->givePermissionTo('update companies');

        $this
            ->actingAs($this->user)
            ->patchJson(route('api.companies.update', $this->company->id), [
                'name' => 'test',
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'name' => 'test',
            ]);
    }

    /**
     * @group update
     * @group crud
     * @group unauthenticated
     */
    public function testCannotUpdateBecauseIsUnauthenticated()
    {
        $this
            ->patchJson(route('api.companies.update', $this->company->id), [
                'name' => 'test',
            ])
            ->assertStatus(401);
    }

    /**
     * @group update
     * @group crud
     * @group unauthorized
     */
    public function testCannotUpdateBecauseUnauthorized()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.companies.update', $this->company->id), [
                'name' => 'test',
            ])
            ->assertStatus(403);
    }
}
