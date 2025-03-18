<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'name' => 'Reguler 1 (Administrasi)',
                'additional_hours' => 19,
            ],
            [
                'name' => 'Reguler 2',
                'additional_hours' => 17,
            ],
            [
                'name' => 'Reguler Ramadan',
                'additional_hours' => 18,
            ],
            [
                'name' => 'Pagi',
                'additional_hours' => 17,
            ],
            [
                'name' => 'Pagi 2',
                'additional_hours' => 21,
            ],
            [
                'name' => 'Siang',
                'additional_hours' => 25,
            ],
            [
                'name' => 'Malam',
                'additional_hours' => 33,
            ],
            [
                'name' => 'Malam 2',
                'additional_hours' => 33,
            ],
            [
                'name' => 'WFA 1 (Administrasi)',
                'additional_hours' => 19,
            ],
            [
                'name' => 'WFA 2',
                'additional_hours' => 17,
            ],
            [
                'name' => 'WFA Ramadan',
                'additional_hours' => 18,
            ]
        ];
        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
