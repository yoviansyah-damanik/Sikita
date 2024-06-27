<?php

namespace Database\Factories;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->numerify('##########'),
            'abstract' => fake()->paragraph(rand(5, 10)),
            'title' => fake()->sentence(),
            'status' => SubmissionStatus::process->name,
        ];
    }
}
