<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DateSchedule>
 */
class DateScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()?->id ?? User::factory()->create()->id;
        $schedule = Schedule::inRandomOrder()->first();
        $date = Carbon::now()->subDays(7)->addDays(rand(0, 14))->startOfDay();

        return [
            'user_id' => $userId,
            'date' => $date->format('Y-m-d'),
            'schedule_id' => $schedule->id,
            'due_date' => $date->addHours($schedule->additional_hours),
        ];
    }
}
