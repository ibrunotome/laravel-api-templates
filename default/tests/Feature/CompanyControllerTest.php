<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    private User $user;

    private Company $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
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
            ->assertOk()
            ->assertJsonFragment([
                'name'     => $this->company->name,
                'maxUsers' => $this->company->max_users,
            ]);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotIndexBecauseIsUnauthorized()
    {
        $this->getJson(route('api.companies.index'))
            ->assertUnauthorized();
    }

    /**
     * @group show
     * @group crud
     * @group forbidden
     */
    public function testCannotIndexBecauseForbidden()
    {
        $this->actingAs($this->user)
            ->getJson(route('api.companies.index'))
            ->assertForbidden();
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
            ->assertOk()
            ->assertJsonFragment([
                'name' => $this->company->name,
            ]);
    }

    /**
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotShowBecauseIsUnauthorized()
    {
        $this
            ->getJson(route('api.companies.show', $this->company->id))
            ->assertUnauthorized();
    }

    /**
     * @group show
     * @group crud
     * @group forbidden
     */
    public function testCannotShowBecauseForbidden()
    {
        $this
            ->actingAs($this->user)
            ->getJson(route('api.companies.show', $this->company->id))
            ->assertForbidden();
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
            ->assertStatus(Response::HTTP_CREATED)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSeeText('is_active');

        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name'      => 'test',
                'is_active' => 'test',
                'max_users' => 0,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSeeText('max_users');
    }

    /**
     * @group store
     * @group crud
     * @group unauthorized
     */
    public function testCannotStoreBecauseIsUnauthorized()
    {
        $this
            ->postJson(route('api.companies.store'), [
                'name' => 'test',
            ])
            ->assertUnauthorized();
    }

    /**
     * @group store
     * @group crud
     * @group forbidden
     */
    public function testCannotStoreBecauseForbidden()
    {
        $this
            ->actingAs($this->user)
            ->postJson(route('api.companies.store'), [
                'name' => 'test',
            ])
            ->assertForbidden();
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
            ->assertOk()
            ->assertJsonFragment([
                'name' => 'test',
            ]);
    }

    /**
     * @group update
     * @group crud
     * @group unauthorized
     */
    public function testCannotUpdateBecauseIsUnauthorized()
    {
        $this
            ->patchJson(route('api.companies.update', $this->company->id), [
                'name' => 'test',
            ])
            ->assertUnauthorized();
    }

    /**
     * @group update
     * @group crud
     * @group forbidden
     */
    public function testCannotUpdateBecauseForbidden()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.companies.update', $this->company->id), [
                'name' => 'test',
            ])
            ->assertForbidden();
    }
}
