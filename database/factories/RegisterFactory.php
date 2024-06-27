<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Register>
 */
class RegisterFactory extends Factory
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
            'name' =>  Str::upper(fake()->name),
            'token' => Str::random(12),
            'email' => fake()->email,
            'expired_at' => Carbon::now()->startOfDay()->addDay(4),
            'stamp' => rand(2020, 2024)
        ];
    }
}
