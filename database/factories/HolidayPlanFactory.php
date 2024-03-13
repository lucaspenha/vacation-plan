<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HolidayPlan>
 */
class HolidayPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'title' => fake()->title(),
                'description' => fake()->paragraphs(10,true),
                'date' => fake()->date('Y-m-d'),
                'location' => fake()->city(),
                'participants' => [fake()->name(),fake()->name(),fake()->name()],
        ];
    }
}
