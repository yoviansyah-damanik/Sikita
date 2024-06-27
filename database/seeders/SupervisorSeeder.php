<?php

namespace Database\Seeders;

use App\Enums\SupervisorType;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Student::all() as $student) {
            $supervisor_1 = Supervisor::create([
                'student_id' => $student->id,
                'lecturer_id' => Lecturer::inRandomOrder()->first()->id,
                'as' => SupervisorType::supervisor_1->name
            ]);

            do {
                $supervisor_2 = Lecturer::inRandomOrder()->first()->id;
            } while ($supervisor_2 == $supervisor_1->lecturer_id);

            Supervisor::create([
                'student_id' => $student->id,
                'lecturer_id' => $supervisor_2,
                'as' => SupervisorType::supervisor_2->name
            ]);
        }
    }
}
