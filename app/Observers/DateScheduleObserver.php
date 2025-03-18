<?php

namespace App\Observers;

use App\Models\{DateSchedule, Note};

class DateScheduleObserver
{
    /**
     * Handle the DateSchedule "created" event.
     */
    public function created(DateSchedule $dateSchedule): void
    {
        Note::create([
            'date_schedule_id' => $dateSchedule->id,
            'note' => '-',
        ]);
    }

    /**
     * Handle the DateSchedule "updated" event.
     */
    public function updated(DateSchedule $dateSchedule): void
    {
        //
    }

    /**
     * Handle the DateSchedule "deleted" event.
     */
    public function deleted(DateSchedule $dateSchedule): void
    {
        //
    }

    /**
     * Handle the DateSchedule "restored" event.
     */
    public function restored(DateSchedule $dateSchedule): void
    {
        //
    }

    /**
     * Handle the DateSchedule "force deleted" event.
     */
    public function forceDeleted(DateSchedule $dateSchedule): void
    {
        //
    }
}
