<?php

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\Service;

/**
 * @extends Factory<Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $starts_at = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $ends_at = (clone $starts_at)->modify('+30 minutes');

        return [
            'doctor_id' => Doctor::factory(),
            'service_id' => Service::factory(),
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'is_available' => true,
        ];
    }
}
