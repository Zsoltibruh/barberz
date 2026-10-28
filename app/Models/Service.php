<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
#[WithoutTimestamps]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }

    /**
     * @return HasMany<BarberService, $this>
     */
    public function barberServices(): HasMany
    {
        return $this->hasMany(BarberService::class);
    }

    /**
     * @return HasMany<Appointment, $this>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
