<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
#[WithoutTimestamps]
class Service extends Model
{
    use HasFactory;

    public function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function barberServices()
    {
        return $this->hasMany(BarberService::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
