<?php

namespace App\Domain\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\Role;
use App\Domain\Users\Entities\User;

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
            'email_verified_at' => now(),
        ]);

        $user->assignRole(Role::ADMIN);

        factory(LoginHistory::class)->create(['user_id' => $user]);
        factory(AuthorizedDevice::class)->create(['user_id' => $user]);
    }
}
