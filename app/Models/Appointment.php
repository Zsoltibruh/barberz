<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['date'])]
#[WithoutTimestamps]
class Appointment extends Model
{
    use HasFactory;

    public function casts(): array
    {
        return [
            'date' => 'datetime',
            'status' => AppointmentStatus::class,
        ];
    }

    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function service()
    {
        return $this->belongsTo(BarberService::class, 'service_id');
    }
}
