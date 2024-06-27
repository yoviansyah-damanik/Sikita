<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StaffSeeder::class);
        // $this->call(LecturerSeeder::class);
        // $this->call(StudentSeeder::class);
        $this->call(GuidanceGroupSeeder::class);
        $this->call(ConfigurationSeeder::class);
        // $this->call(RegisterSeeder::class);
        // $this->call(SubmissionSeeder::class);
        // $this->call(SupervisorSeeder::class);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
