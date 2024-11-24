<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->realText(100),
            'description' => fake()->realText(250),
            'due_date' => fake()->dateTimeThisMonth()->format('d/m/Y'),
            'user_id' => 1
        ];
    }
}
