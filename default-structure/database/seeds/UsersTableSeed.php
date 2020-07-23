<?php

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
        $user = factory(User::class)->create([
            'email'             => 'test@test.com',
            'email_verified_at' => now(),
        ]);

        $user->assignRole(Role::ADMIN);

        factory(LoginHistory::class)->create(['user_id' => $user]);
        factory(AuthorizedDevice::class)->create(['user_id' => $user]);
    }
}
