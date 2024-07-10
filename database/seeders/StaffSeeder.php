<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(
            [
                'password' => bcrypt('password'),
                'email' => 'sikita@example.com'
            ]
        );

        $staff = Staff::create([
            'id' => '1234567890',
            'name' => 'Administrator',
            'phone_number' => '082272164836'
        ]);

        $userType = new UserType(['user_id' => $user->id]);

        $staff->userable()->save($userType);
    }
}
