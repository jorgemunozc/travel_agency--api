<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomDate = now()->addMonths(rand(1, 10))->toImmutable();

        return [
            'name' => fake()->unique()->text(150),
            'starting_date' => $randomDate,
            'ending_date' => $randomDate->addDays(fake()->numberBetween(1, 15)),
            'price' => fake()->randomFloat(2, 150, 200_000),
        ];
    }
}
