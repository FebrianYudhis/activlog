<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $guarded = [];

    public function dateSchedules(): HasMany
    {
        return $this->hasMany(DateSchedule::class);
    }
}
