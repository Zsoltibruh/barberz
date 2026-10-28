<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;

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

    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }
}
