<?php

namespace App\Policies;

use App\Models\DateSchedule;
use App\Models\User;
use Carbon\Carbon;

class DateSchedulePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DateSchedule $dateSchedule): bool
    {
        return $dateSchedule->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model (e.g. update status).
     */
    public function updateStatus(User $user, DateSchedule $dateSchedule): bool
    {
        return $dateSchedule->user_id === $user->id &&
               now()->gt($dateSchedule->due_date) &&
               $dateSchedule->tasks()->count() == 0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DateSchedule $dateSchedule): bool
    {
        return $dateSchedule->user_id === $user->id &&
               now()->lt($dateSchedule->due_date);
    }

    /**
     * Determine whether the user can create tasks for the schedule.
     */
    public function manageTask(User $user, DateSchedule $dateSchedule): bool
    {
        return $dateSchedule->user_id === $user->id &&
               now()->lt($dateSchedule->due_date);
    }

    public function updateNote(User $user, DateSchedule $dateSchedule): bool
    {
        return $user->id === $dateSchedule->user_id && now()->lt($dateSchedule->due_date);
    }
}
