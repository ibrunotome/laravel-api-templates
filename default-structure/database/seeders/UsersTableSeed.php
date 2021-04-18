<?php

namespace Database\Seeders;

use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\Role;
use App\Models\User;
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
