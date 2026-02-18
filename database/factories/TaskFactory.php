<?php

namespace Database\Factories;

use App\Models\DateSchedule;
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
        $dateScheduleId = DateSchedule::inRandomOrder()->first()?->id ?? DateSchedule::factory()->create()->id;

        return [
            'date_schedule_id' => $dateScheduleId,
            'task' => $this->faker->sentence,
            'time' => $this->faker->time('H:i:s'),
        ];
    }
}
