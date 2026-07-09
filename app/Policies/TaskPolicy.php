<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->dateSchedule->user_id === $user->id &&
               now()->lt($task->dateSchedule->due_date);
    }
}
