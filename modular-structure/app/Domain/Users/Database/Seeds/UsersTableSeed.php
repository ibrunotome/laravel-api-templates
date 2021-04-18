<?php

namespace App\Domain\Users\Database\Seeds;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\Role;
use App\Domain\Users\Entities\User;
use Illuminate\Database\Seeder;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'email'             => 'test@test.com',
            'email_verified_at' => now(),
        ]);

        $user->assignRole(Role::ADMIN);

        LoginHistory::factory()->create(['user_id' => $user]);
        AuthorizedDevice::factory()->create(['user_id' => $user]);
    }
}
