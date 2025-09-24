<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sunday_start_at' => '09:00:00',
            'sunday_ends_at' => '17:00:00',
            'monday_start_at' => '09:00:00',
            'monday_ends_at' => '17:00:00',
            'tuesday_start_at' => '09:00:00',
            'tuesday_ends_at' => '17:00:00',
            'wednesday_start_at' => '09:00:00',
            'wednesday_ends_at' => '17:00:00',
            'thursday_start_at' => '09:00:00',
            'thursday_ends_at' => '17:00:00',
        ];
    }
}
