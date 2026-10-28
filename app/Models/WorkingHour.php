<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['weekday', 'start_time', 'end_time'])]
#[WithoutTimestamps]
class WorkingHour extends Model
{
    public function casts(): array
    {
        return [
            'weekday' => 'string',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function barber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'barber_id');
    }
}
