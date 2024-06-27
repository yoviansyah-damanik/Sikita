<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory()
            ->count(50)
            ->hasUserable(1)
            ->create();
    }
}
