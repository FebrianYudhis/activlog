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
        // Note is now a column in date_schedules. 
        // We can let it be null or set it to '-' when creating the DateSchedule directly.
        // If we want a strict default '-', we can set it here:
        if (is_null($dateSchedule->note)) {
            $dateSchedule->updateQuietly(['note' => '-']);
        }
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
