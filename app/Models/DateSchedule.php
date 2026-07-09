<?php

namespace App\Models;

use App\Observers\DateScheduleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

#[ObservedBy(DateScheduleObserver::class)]
class DateSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_invalid' => 'boolean',
            'is_checked' => 'boolean',
            'date' => 'date:Y-m-d',
            'due_date' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // note() removed because note is now a column in date_schedules table

    public function scopeInvalid(Builder $query): Builder
    {
        return $query->whereNotNull('is_invalid');
    }

    public function scopeValid(Builder $query): Builder
    {
        return $query->whereNull('is_invalid');
    }

    public function scopeUnchecked(Builder $query): Builder
    {
        return $query->whereNull('is_checked');
    }

    public function scopeChecked(Builder $query): Builder
    {
        return $query->whereNotNull('is_checked');
    }
}
