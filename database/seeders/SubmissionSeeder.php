<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Student::all() as $student) {
            if (rand(0, 1))
                Submission::factory()
                    ->count(3)
                    ->for($student)
                    ->create();
        }
    }
}
