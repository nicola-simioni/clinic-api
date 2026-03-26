<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'duration_minutes' => $this->faker->randomElement([15, 30, 45, 60]),
            'price' => $this->faker->randomFloat(2, 20, 200),
            'is_active' => true,
        ];
    }
}
