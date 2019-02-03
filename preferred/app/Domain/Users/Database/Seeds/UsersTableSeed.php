<?php

namespace Preferred\Domain\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\Role;
use Preferred\Domain\Users\Entities\User;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'email'             => 'test@test.com',
            'email_verified_at' => now()
        ]);

        $user->assignRole(Role::ADMIN);

        factory(Profile::class)->create(['user_id' => $user]);
        factory(LoginHistory::class)->create(['user_id' => $user]);
        factory(AuthorizedDevice::class)->create(['user_id' => $user]);
    }
}
