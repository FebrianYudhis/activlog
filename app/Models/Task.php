<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    public function dateschedule(): BelongsTo
    {
        return $this->belongsTo(DateSchedule::class);
    }
}
