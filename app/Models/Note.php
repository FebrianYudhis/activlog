<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $guarded = [];

    public function dateSchedule(): BelongsTo
    {
        return $this->belongsTo(DateSchedule::class);
    }
}
