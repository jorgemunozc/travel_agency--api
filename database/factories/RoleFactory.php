<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = Roles::cases();

        return [
            'name' => fake()->randomElement($roles),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => Roles::Admin,
        ]);
    }

    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => Roles::Editor,
        ]);
    }

    public function normal(): static
    {
        return $this->state(fn () => [
            'name' => Roles::Normal,
        ]);
    }
}
