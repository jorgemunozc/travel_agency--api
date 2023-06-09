<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_public' => fake()->boolean(),
            'name' => fake()->unique()->text(100),
            'description' => fake()->text(),
            'num_of_days' => fake()->randomNumber(2),
        ];
    }

    public function public(): static
    {
        return $this->state(fn () => [
            'is_public' => true,
        ]);
    }

    public function private(): static
    {
        return $this->state(fn () => [
            'is_public' => false,
        ]);
    }
}
